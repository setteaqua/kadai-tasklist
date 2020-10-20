@if (count($tasks) > 0)
    <h1>タスク一覧</h1>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>id</th>
                <th>ステータス</th>
                <th>タスク内容</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
               <tr>
                    {{--タスク内容--}}
                    <td>{!! link_to_route('tasks.show', $task->id, ['task' => $task->id]) !!}</td>
                    <td>{!! nl2br(e($task->status)) !!}</td>
                    <td>{!! nl2br(e($task->content)) !!}</td>
               </tr>
            @endforeach
        </tbody>
    </table>
    
    {{--ページネーションのリンク--}}
    {{ $tasks->links() }}

@endif