<?php

namespace Dotlogics\Grapesjs\App\Traits;

use Dotlogics\Grapesjs\App\Editor\Config;
use Illuminate\Http\Request;

trait EditorTrait{

	protected function show_gjs_editor(Request $request, $model){
		$editorConfig = app(Config::class)->initialize($model);
		
		return view('laravel-grapesjs::edittor', compact('editorConfig', 'model'));
	}

	protected function store_gjs_data(Request $request, $model)
	{	
		$model->gjs_data = [
	        'components' => $request->get('laravel-grapesjs-components'),
	        'styles' => $request->get('laravel-grapesjs-styles'),
	        'css' => $request->get('laravel-grapesjs-css'),
	        'html' => $request->get('laravel-grapesjs-html'),
	    ];

	    $model->save();
		
	    $path = public_path("plugin_html/" . tenant('id') . "/" . $model->slug . ".html");
            $myfile = fopen(trim($path),"w") or die("Unable to open file!");
            fwrite($myfile, $model->content);
            fclose($myfile);

	    return response()->noContent(200);
	}
}
