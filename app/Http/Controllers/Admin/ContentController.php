<?php namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use App\Content;

class ContentController extends BaseController
{
    /**
     * Get content index
     * 
     * @return \Illuminate\View\View
     */
    public function index()
	{
		return view('admin/contents');
	}
    
    /**
     * Edit content
     * 
     * @param Content $content
     * @return \Illuminate\View\View
     */
    public function form(Content $content)
	{
        if (!$content->isUserAllowed(\Auth::user())) {
            return response(view('admin/unauthorized'), 401);
        }
		return view('admin/contents-edit', compact('content'));
	}
    
    /**
     * Save content
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function save()
    {
        $input = \Input::except('_token');
        
        // Pre validation
        $input['seo_slug'] = empty($input['seo_slug']) ? str_slug($input['title']) : $input['seo_slug'];
        $input['publish_start'] = empty($input['publish_start']) ? null : $input['publish_start'];
        $input['publish_end'] = empty($input['publish_end']) ? null : $input['publish_end'];
        $input['event']['start'] = empty($input['event']['start']) ? null : $input['event']['start'];
        $input['event']['end'] = empty($input['event']['end']) ? null : $input['event']['end'];
        
        // Validate
        $validator = \Validator::make($input, [
            'title' => 'required|max:255',
            'seo_slug' => 'unique:contents'.(!empty($input['id']) ? ',seo_slug,'.$input['id'] : ''),
            'content' => 'required'
        ]);
        
        // When fails
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->messages()]);
        }
        
        // Load content
        if (empty($input['id'])) {
            $content = new Content;
            $content->user_id = \Auth::user()->id;
        } else {
            $content = Content::with(['event', 'location'])->find($input['id']);
        }
        
        // Validate permission
        if (!$content->isUserAllowed(\Auth::user())) {
            return response('', 401)->json(['success' => false]);
        }
        
        // Save changes
        $content->fill($input);
        $content->save();
        
        // Process relations
        $content->savePicture(\Request::file('file-0'), $input['image_max_width']);
        $content->saveEvent($input['event']);
        $content->saveLocation($input['location']);
        
        // Response
        return response()->json(['success' => 'Content saved', 'redirect' => url('/admin/contents/list')]);
    }
    
    /**
     * Upload images
     * 
     * @param Content $content
     * @return \Illiminate\Http\JsonResponse
     */
    public function upload(Content $content)
    {
        // Process seo image
        if ($file = \Request::file('image_uploader')) {
            $filename = md5(microtime()).'.'.$file->getClientOriginalExtension();
            $file->move(public_path($content->getGalleryPath()), $filename);
            
            // Go resize if not empty
            $maxWidth = \Input::get('image_max_width');
            if (!empty($maxWidth)) {
                $content->resizeImage(public_path($content->getGalleryPath().'/'.$filename), $maxWidth);
            }
        }
        
        // Response
        return response()->json(['success' => true]);
    }
    
    /**
     * Delete image
     * 
     * @param Content $content
     * @return \Illiminate\Http\JsonResponse
     */
    public function deleteGalleryImage(Content $content, $image)
    {
        $result = unlink($content->getGalleryPath().'/'.$image);
        return response()->json(['success' => $result]);
    }
    
    /**
     * Get all contents
     * 
     * @param Content $content
     * @return \Illiminate\Http\JsonResponse
     */
    public function json()
	{
		return response()->json(['data' => Content::all()]);
	}
    
    /**
     * Delete content
     * 
     * @param Content $content
     * @return \Illiminate\Http\RedirectResponse
     */
    public function delete(Content $content)
    {
        $content->delete();
        return redirect('admin/contents/list');
    }

}
