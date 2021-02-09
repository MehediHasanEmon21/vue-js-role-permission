<?php

namespace App\Http\Controllers\Admin;

use App\Model\Work;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Model\UserWork;

class WorkController extends Controller
{
    public function add_work(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|unique:works'
        ]);

        $name_list =  explode(" ", $request->name);
        $name_list = array_map('strtolower', $name_list);
        $work_slug = implode("-", $name_list);
        $similar_slug = DB::table('works')->where('slug', 'like', $work_slug . '%')->get();
        if (count($similar_slug) > 0) {
            $slug = $work_slug . '-' . Str::random(20);
        } else {
            $slug = $work_slug;
        }

        $work = new Work();
        $work->name = $request->name;
        $work->slug = preg_replace('/[^a-zA-Z0-9]+/', '-', $slug);
        $work->save();
    }

    public function all_work()
    {
        $works = Work::orderBy('id', 'DESC')->paginate(8);
        return response()->json(['works' => $works]);
    }


    public function edit($slug)
    {

        $work = Work::where('slug', $slug)->first();
        return response()->json(['work' => $work]);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:works'
        ]);

        $name_list =  explode(" ", $request->name);
        $name_list = array_map('strtolower', $name_list);
        $work_slug = implode("-", $name_list);
        $similar_slug = DB::table('works')->where('slug', 'like', $work_slug . '%')->get();
        if (count($similar_slug) > 0) {
            $slug = $work_slug . '-' . Str::random(20);
        } else {
            $slug = $work_slug;
        }

        $work = Work::where('id', $request->id)->first();
        $work->name = $request->name;
        $work->slug = preg_replace('/[^a-zA-Z0-9]+/', '-', $slug);
        $work->save();
    }

    public function delete_work($slug)
    {

        $work = Work::where('slug', $slug)->first();
        $work->delete();
    }

    public function all_works()
    {
        $works = Work::orderBy('name', 'ASC')->get();
        return response()->json(['works' => $works]);
    }

    public function add_user_work(Request $request)
    {


        $work_type = $request->work_id;

        if ($work_type == "new_work") {

            $this->validate($request, [
                'name' => 'required',
                'department_id' => 'required',
                'user_id' => 'required',
            ]);

            $name_list =  explode(" ", $request->name);
            $name_list = array_map('strtolower', $name_list);
            $work_slug = implode("-", $name_list);
            $similar_slug = DB::table('works')->where('slug', 'like', $work_slug . '%')->get();
            if (count($similar_slug) > 0) {
                $slug = $work_slug . '-' . Str::random(20);
            } else {
                $slug = $work_slug;
            }

            $work = new Work();
            $work->name = $request->name;
            $work->slug = preg_replace('/[^a-zA-Z0-9]+/', '-', $slug);
            $work->save();

            $user_work = new UserWork();
            $user_work->work_id = $work->id;
            $user_work->department_id = $request->department_id;
            $user_work->user_id = $request->user_id;
            $user_work->save();
        } else {

            $this->validate($request, [
                'work_id' => 'required',
                'department_id' => 'required',
                'user_id' => 'required',
            ]);



            $user_work = new UserWork();
            $user_work->work_id = $request->work_id;
            $user_work->department_id = $request->department_id;
            $user_work->user_id = $request->user_id;
            $user_work->save();
        }
    }

    public function all_user_work()
    {
        $user_works = UserWork::with(['user', 'work', 'department'])->orderBy('id', 'DESC')->paginate(8);
        return response()->json(['user_works' => $user_works]);
    }
}
