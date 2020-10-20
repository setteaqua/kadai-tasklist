<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Task;       //追加

class TasksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    //getでtasks/にアクセスされた場合の「一覧表示機能」
    public function index()
    {
        
        $data = [];
        
        //認証を実行
        if(\Auth::check()){
            
            //認証済みユーザを取得
            $user = \Auth::user();
            
            //ユーザのタスク一覧を取得 (１ページにつき10件)
            $tasks = $user->tasks()->paginate(10);
            
            $data = [
                "user" => $user,
                "tasks" => $tasks,
            ];
            
        }
        
        
        //タスク一覧ビューでそれを表示
        return view("welcome",$data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    //getでtasks/createにアクセスされた場合の「新規登録画面表示処理」
    public function create()
    {
        $task = new Task;
        
        //タスク作成ビューを表示
        
        return view("tasks.create",[
            "task" => $task,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    //getでtasks/にアクセスされた場合の「新規登録処理」
    public function store(Request $request)
    {
        //バリデーションを追加
        $request->validate([
            
                "status" => "required|max:10",
                "content" => "required|max:50",
            
            ]);
        
        
        //タスクを作成
        $task = new Task;
        $task->status = $request->status;
        $task->user_id = \Auth::id();
        $task->content = $request->content;
        //$task->save();
        
        
        //認証済みユーザのタスクとして作成
        $request->user()->tasks()->create([
            "status" => $request->status,
            "content" => $request->content,
        ]);
        
        
        //トップメニューへリダイレクトされる
        return redirect("/");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //getでtasks/(任意のid)にアクセスされた場合の「取得表示処理」
    public function show($id)
    {
        
         //idの値でメッセージを検索して取得
            $task = Task::findOrFail($id);
        
            //メッセージ詳細ビューでそれを表示
            return view("tasks.show",[
                "task" => $task,
            ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //getでtask/(任意のid)/editにアクセスされた場合の「更新画面表示処理」
    public function edit($id)
    {
        // idの値でメッセージを検索して取得
        $task = Task::findOrFail($id);
        
        //認証済みユーザ（閲覧者）がそのタスクの登録者である場合は、投稿を閲覧
        if(\Auth::id() === $task->user_id){
        
            //メッセージ編集ビューでそれを表示
            return view("tasks.edit",[
                "task"=> $task,
            ]);
        }
        else{
           return redirect("/"); 
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //getでtasks/(任意のid)にアクセスされた場合の「更新処理」
    public function update(Request $request, $id)
    {
        
        //バリデーションを追加
        $request->validate([
            
                "status" => "required|max:10",
                "content" => "required|max:50",
            
            ]);
        
        
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        
        //認証済みユーザ（閲覧者）がそのタスクの登録者である場合は、投稿を閲覧
        if(\Auth::id() === $task->user_id){
        
            //タスクを更新  
            $task->status = $request->status;
            $task->content = $request->content;
            $task->save();
        
        //トップページへリダイレクトさせる
             return redirect("/");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    //getでtasks/(任意のid)にアクセスされた場合の「削除処理」
    public function destroy($id)
    {
        // idの値でタスクを検索して取得
        $task = Task::findOrFail($id);
        
        
        //認証済みユーザ（閲覧者）がそのタスクの登録者である場合は、投稿を閲覧
        if(\Auth::id() === $task->user_id){
        
            //メッセージを削除  
            $task->delete();
            
            //トップページへリダイレクトさせる
            return redirect("/");
        }
    }
}
