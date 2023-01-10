<?php

use App\User;
use App\Blog;
use App\Tag;


function tag_name($tag_id)
{
	if(isset($tag_id))
	{
		if( is_array($tag_id) )
		{
			return Tag::whereIn('id', $tag_id)->pluck('tag');			
		}else{
			return Tag::where('id', $tag_id)->first()->tag;			
		}
	}	
}


function blog_public_path(){
	return asset('/').'storage/blogs/';
}

function store_blog_path()
{
    return storage_path() . '/app/public/blogs/';
}

// Upload files
function uploadFile($file, $dir, $filecount = null) {
    $ext = $file->getClientOriginalExtension();
    if($ext != ''){
        $fileName = time() . $filecount . '.' . $ext;

    }else{
        $ext = $file->extension();
        $fileName = time() . $filecount . '.' . $ext;

    }

    Storage::disk('public')->putFileAs($dir, $file, $fileName);

    return $fileName;
}

//remove file
function removeFile($file, $dir) {
    $existImage = storage_path() . '/app/public/' . $dir . '/' . $file;
    if (File::exists($existImage)) {
        File::delete($existImage);
    }
}
