<?php

namespace Bageur\Page;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Bageur\Page\model\page;
use Illuminate\Support\Str;
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
        // return $request;
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
            if ($request->judul_seo == null) {
                $page->judul_seo    = Str::slug($request->judul);
            }else{
                $page->judul_seo    = $request->judul_seo;
            }
            $page->semua_meta         = json_encode($input);
            $page->type               = $request->type;
            $page->status             = $request->status;
            $page->konten             = \Bageur::textarea($request->konten);
            $page->training_id        = $request->training_id;
            $page->training_jenis_id  = $request->training_jenis_id;
            $page->training_group_id  = $request->training_group_id;
            $page->view               = $request->view;
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
        return $page;
        // $data = ['judul' => $page->judul , 'semua_meta' => $page->semua_meta , 'type' => $page->type , 'status' => $page->status, 'konten' => $page->konten];
        // return response()->json($data);
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
            if (empty($request->judul_seo)) {
                $page->judul_seo    = Str::slug($request->nama_jadwal);
            }else{
                $page->judul_seo    = $request->judul_seo;
            }
            $page->semua_meta   = json_encode($request->include);
            $page->type         = $request->type;
            $page->status       = $request->status;
            $page->konten       = \Bageur::textarea($request->konten);
            $page->training_id        = $request->training_id;
            $page->training_jenis_id  = $request->training_jenis_id;
            $page->training_group_id  = $request->training_group_id;
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
