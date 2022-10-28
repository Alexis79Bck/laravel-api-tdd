<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function list()
    {
        $blogs = auth()->user()->blogs;

        return count($blogs) == 0 ? response([ "status" => 1, "msg" => "No tiene ningun blog creado.",  "alert" => 'warning', "data" => $blogs ]) : response([ "status" => 1, "msg" => "Se muestra el listado de " . count($blogs) . " Blogs",  "alert" => 'success', "data" => $blogs ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $validate = $this->validateData($request);
        $user_id = auth()->user()->id;

        $blog = Blog::create([
            'user_id' => $user_id,
            'title' => $validate['title'],
            'content' => $validate['content']
        ]);

        return response([
            "status" => 1,
            "msg" => "¡Blog Creado Exitosamente.",
            "alert" => 'success'
            ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

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
        $user_id = auth()->user()->id;

        if (Blog::where(['user_id'=>$user_id, 'id'=>$id])->exists()){
            $blog = Blog::find($id);
            $blog->title = $request->title ?? $blog->title;
            $blog->content = $request->content ?? $blog->content;
            $blog->save();
            return response([
                "status" => 1,
                "msg" => "¡Blog Actualizado.",
                "alert" => 'success'
                ]);

        }else{
            return response([
                "status" => 0,
                "msg" => "¡Blog no existe.",
                "alert" => 'danger'
                ], 404);
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
        $user_id = auth()->user()->id;

        if (Blog::where(['user_id'=>$user_id, 'id'=>$id])->exists()){
            $blog = Blog::where(['user_id'=>$user_id, 'id'=>$id])->first();
            $blog->delete();

            return response([
                "status" => 1,
                "msg" => "¡Blog Eliminado.",
                "alert" => 'success'
                ]);

        }else{
            return response([
                "status" => 0,
                "msg" => "¡Blog no existe.",
                "alert" => 'danger'
                ], 404);
        }
    }

    /**
     * Validates the data submitted in the type of request that sends it.
     * the type can be register o login.
     *
     * @param Request $request
     * @param string $type
     * @return mixed
     */
    private function validateData(Request $request)
    {

        $rules =[
            'title' => 'required|max:50',
            'content' =>  'required'
        ];

        return $request->validate($rules);
    }
}
