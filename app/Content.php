<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Content extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'contents';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['lang', 'title', 'seo_slug', 'content', 'seo_title', 'seo_description', 'seo_author', 'seo_keywords', 'content', 'role_permission', 'publish_start', 'publish_end'];

    /**
     * User relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {

        return $this->belongsTo('App\User');
    }

    /**
     * Visit relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function visits()
    {
        return $this->hasMany('App\Visit');
    }

    /**
     * Event relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function event()
    {
        return $this->hasOne('App\Event');
    }

    /**
     * Location relation
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function location()
    {
        return $this->hasOne('App\Location');
    }

    /**
     * Get content with filters
     *
     * @return string
     */
    public function getContent()
    {
        return $this->addContentFilters($this->content);
    }

    /**
     * Adds content filters
     *
     * @return string
     */
    public function addContentFilters($content)
    {
        // Embed youtube
        $matchYoutube = preg_match('/https\:\/\/www\.youtube\.com\/watch\?v\=([\w\d-_]+)/', $content, $matches);
        if (!empty($matchYoutube)) {
            $content = str_replace($matches[0], '<iframe width="100%" height="320" src="https://www.youtube.com/embed/'.$matches[1].'" frameborder="0" allowfullscreen></iframe>', $content);
        }

        // Embed Vimeo
        $matchVimeo = preg_match('/https\:\/\/vimeo\.com\/([\d]+)/', $content, $matches);
        if (!empty($matchVimeo)) {
            $content = str_replace($matches[0], '<iframe src="https://player.vimeo.com/video/'.$matches[1].'" width="100%" height="320" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>', $content);
        }

        return $content;
    }

    /**
     * Save content main picture
     *
     * @param null|File $file
     */
    public function savePicture($file, $maxWidth = 1024)
    {
        if ($file) {
            $filename = 'picture.'.$file->getClientOriginalExtension();
            $file->move(public_path($this->getStoragePath()), $filename);
            $this->seo_image = $filename;
            $this->save();

            // Go resize if not empty
            if (!empty($maxWidth)) {
                $this->resizeImage(public_path($this->getStoragePath().'/'.$filename), $maxWidth);
            }
        }
    }

    public function resizeImage($filename, $maxWidth = 1024, $quality = 90)
    {
        $img = \Image::make($filename);
        if ($img->width() > $maxWidth) {
            $img->resize($maxWidth, null, function ($constraint) {
                $constraint->aspectRatio();
            });
            $img->save($filename, $quality);
        }
    }

    /**
     * Save event if not empty
     *
     * @param array $event
     */
    public function saveEvent($event)
    {
        if (!empty($event['start'])) {
            if (empty($this->event)) {
                $this->event()->create($event);
            } else {
                $this->event->fill($event);
                $this->event->save();
            }
        } elseif ($this->event) {
            $this->event->delete();
        }
    }

    /**
     * Save location if not empty
     *
     * @param array $location
     */
    public function saveLocation($location)
    {
        if (!empty($location['lat'])) {
            if (empty($this->location)) {
                $this->location()->create($location);
            } else {
                $this->location->fill($location);
                $this->location->save();
            }
        } elseif ($this->location) {
            $this->location->delete();
        }
    }

    /**
     * Get available languages
     *
     * @return array
     */
    public function getAvailableLanguages()
    {
        $langs = [];
        foreach(glob(base_path('resources/lang/*', GLOB_ONLYDIR)) as $dir) {
            $langs[] = basename($dir);
        }
        return $langs;
    }

    /**
     * Get content storage path
     *
     * @return string
     */
    public function getStoragePath()
    {
        return 'storage/content/'.$this->id;
    }

    /**
     * Get public storage path
     *
     * @return string
     */
    public function getPublicStoragePath()
    {
        return public_path('storage/content/'.$this->id);
    }

    /**
     * Copy content
     *
     * @param Content $target
     * @return string
     */
    public function copy(Content $target)
    {
        // Copy picture
        $target->seo_image = $this->seo_image;
        if (!is_dir($target->getPublicStoragePath())) {
            mkdir ($target->getPublicStoragePath());
        }
        copy($this->getPublicStoragePath().'/'.$this->seo_image, $target->getPublicStoragePath().'/'.$target->seo_image);

        // Copy event
        $target->event ? $target->event->delete() : false;
        $target->event()->create(['start' => $this->event->start, 'end' => $this->event->end]);

        // Copy location
        $target->location ? $target->location->delete() : false;
        $target->location()->create([
            'address' => $this->location->address,
            'lat' => $this->location->lat,
            'lon' => $this->location->lon,
            'zoom' => $this->location->zoom
        ]);
    }

    /**
     * Get gallery storage path
     *
     * @return string
     */
    public function getGalleryPath()
    {
        return 'storage/content/'.$this->id.'/gallery';
    }

    /**
     * Get gallery temporary storage path
     *
     * @return string
     */
    public function getTempGalleryPath()
    {
        return 'storage/content/temp_gallery_'.\Auth::id();
    }

    /**
     * Get all gallery images
     *
     * @return array
     */
    public function getGalleryImages()
    {
        $items = glob(public_path($this->getGalleryPath()).'/*.{jpg,png,gif}', GLOB_BRACE);
        return $items;
    }
    /**
     * Get all temparary gallery images
     *
     * @return array
     */
    public function getTempGalleryImages()
    {
        $items = glob(public_path($this->getTempGalleryPath()).'/*.{jpg,png,gif}', GLOB_BRACE);
        return $this->pathUnixFormat($items);
    }

    /**
     * Get image url
     *
     * @param string $image
     * @return string
     */
    public function getGalleryImageUrl($image)
    {
        return asset($this->getGalleryPath()).'/'.basename($image);
    }

    /**
     * Get attachments storage path
     *
     * @return string
     */
    public function getAttachmentsPath()
    {
        return 'storage/content/'.$this->id.'/attachments';
    }

    /**
     * Get attachments
     *
     * @return array
     */
    public function getAttachments()
    {
        $items = glob(public_path($this->getAttachmentsPath()).'/*.{doc,docx,xls,xlsx,ppt,pptx,pdf,zip}', GLOB_BRACE);
        return $items;
    }

    /**
     * Get attachment url
     *
     * @param string $attachment
     * @return string
     */
    public function getAttachmentUrl($attachment)
    {
        return asset($this->getAttachmentsPath()).'/'.basename($attachment);
    }

    /**
     * Get main picture url
     *
     * @return string
     */
    public function getPictureUrl()
    {
        return asset($this->getStoragePath().'/'.$this->seo_image);
    }

    /**
     * Check if contaent has picture
     *
     * @return boolean
     */
    public function hasPicture()
    {
        return is_file(public_path($this->getStoragePath().'/'.$this->seo_image));
    }

    /**
     * Check if value permission is selected
     *
     * @param type $value
     * @return boolean
     */
    public function isRolePermission($value)
    {
        if (empty($this->role_permission) && $value == 'NONE') {
            return true;
        }
        return $this->role_permission == $value;
    }

    /**
     * Check if target user is allowed to edit this content
     *
     * @param App\User $user
     * @return boolean
     */
    public function isUserAllowed($user)
    {
        $result = true;
        $permission = $this->role_permission;

        // USER overrides ROLE, ROLE overrides NONE
        foreach ($user->roles as $role) {
            if ($role->content_permission == 'USER') {
                $permission = 'USER';
            } elseif ($role->content_permission == 'NONE') {
                $permission = $permission;
            } else {
                $permission = $role->content_permission;
            }
        }

        switch ($permission) {
            case 'USER':
                $result = $this->user->id == $user->id;
                break;
            case 'ROLE':

                // Check if target USER belongs to content OWNER ROLES
                foreach($this->user->roles as $role) {
                    $result = $result & $role->users->contains($user->id);
                }
                break;
            default:
                $result = true;
        }
        return $result;
    }
    /**
     * Empty old temporary gallery directory to free space for new temparay gallery
     */
    public function clearTempGallery()
    {
        if (is_dir($this->getTempGalleryPath()))
        {
            \File::cleanDirectory($this->getTempGalleryPath());
        }
    }
    /**
     * save temporary gallery images to the current content
     */
    public function saveGallery()
    {
        $temp_gallery = $this->getTempGalleryImages();

        foreach ($temp_gallery as $temp_image_path)
        {
            $temp_path = public_path($this->getTempGalleryPath());
            $temp_path  = $this->pathUnixFormat($temp_path);

            $content_gallery_path = public_path($this->getGalleryPath());
            $content_gallery_path  = $this->pathUnixFormat($content_gallery_path);

            $image_new_path = str_replace($temp_path, $content_gallery_path, $temp_image_path);

            if (!is_dir($content_gallery_path))
            {
                mkdir($content_gallery_path, 0755, true);
            }

            \File::move($temp_image_path, $image_new_path);
        }
    }

    /**
     * convert paths to unix-like if app is runing on windows
     */
    public static function pathUnixFormat($paths)
    {
        $path_unix_format = array();

        if(is_string($paths))
        {   // single path
            return str_replace("\\", "/", $paths);
        }

        foreach ($paths as $path)
        {
            $path_unix_format[] = str_replace("\\", "/", $path);
        }
        return $path_unix_format;
    }
}
