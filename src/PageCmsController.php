<?php

namespace Bageur\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bageur\Page\model\page;
use Validator;

class PageCmsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $page = page::datatable($request);
        return $page;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules    	= [
                        'judul'		     		=> 'required'
                    ];

        $messages 	= [];
        $attributes = [];

        $validator = Validator::make($request->all(), $rules,$messages,$attributes);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response(['status' => false ,'error'    =>  $errors->all()], 200);
        }else{
            foreach ($request->datameta as $key => $value) {
                $input[] = ['name' => $value['name'] , 'content' => $value['content']];
            }
            $page               = new page;
            $page->judul        = $request->judul;
            $page->semua_meta   = json_encode($input);
            $page->type         = $request->type;
            $page->status       = $request->status;
            $page->konten       = $request->konten;
            $page->view         = $request->view;
            $page->save();

            return response(['status' => true ,'text'    => 'has input'], 200);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $page = page::findOrFail($id);
        $data = ['judul' => $page->judul , 'semua_meta' => $page->semua_meta , 'type' => $page->type , 'status' => $page->status, 'konten' => $page->konten];
        return response()->json($data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $rules    	= [
                        'judul'		     		=> 'required'
                    ];

        $messages 	= [];
        $attributes = [];

        $validator = Validator::make($request->all(), $rules,$messages,$attributes);
        if ($validator->fails()) {
            $errors = $validator->errors();
            return response(['status' => false ,'error'    =>  $errors->all()], 200);
        }else{
            foreach ($request->datameta as $key => $value) {
                $input[] = ['name' => $value['name'] , 'content' => $value['content']];
            }
            $page               = page::findOrFail($id);
            $page->judul        = $request->judul;
            $page->semua_meta   = json_encode($request->include);
            $page->type         = $request->type;
            $page->status       = $request->status;
            $page->konten       = $request->konten;
            $page->view         = $request->view;
            $page->save();

            return response(['status' => true ,'text'    => 'has update'], 200);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $delete = page::findOrFail($id);
        $delete->delete();
        return response(['status' => true ,'text'    => 'has deleted'], 200);
    }
}