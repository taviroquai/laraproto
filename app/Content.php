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
     * Save content main picture
     * 
     * @param null|File $file
     */
    public function savePicture($file)
    {
        if ($file) {
            $filename = 'picture.'.$file->getClientOriginalExtension();
            $file->move(public_path($this->getStoragePath()), $filename);
            $this->seo_image = $filename;
            $this->save();
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
     * Get gallery storage path
     * 
     * @return string
     */
    public function getGalleryPath()
    {
        return 'storage/content/'.$this->id.'/gallery';
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
}
