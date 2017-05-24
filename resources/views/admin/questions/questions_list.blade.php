@extends('admin.layout.layout')
@section('content')
<div id="page-container">
    <div id="page-body">
        <h1 class="section-title title-exam">建立試題</h1>
        <div class="section-content">
            <ul id="exam-unit-wrap" class="clearfix">
                <li><a href="[! route('ad.exampaper.add.page') !]">新增試卷</a></li>
                <li><a href="[! route('ad.questions.add.page') !]">新增試題</a></li>
                <li><a class="current-page" href="[! route('ad.exampaper.vol.list.page') !]">編修試卷</a></li>
            </ul>
            <div class="exam-title">
                試卷名稱：單代理人 數學(單代理人)第1冊第1單元【b506】－卷02
                <input class="btn btn-delete" type="button" value="刪除試卷" onclick="del_exampaper()">
            </div>
            <form id="form-addexam-question">
                @foreach($questions as $k => $v)
                    <div class="question-unit">
                        <div class="question-number">【[! $k+1 !]】</div>
                        <div class="question-content">
                            <div class="question-img">
                                [! $v["title"] !]
                            </div>
                            <div class="question-text-wrap clearfix">
                                <div class="question-right-wrap">
                                    <div class="question-button clearfix">
                                        <a href="[! route('ad.questions.edit',array($v['id'])) !]" class="button-edit">修改</a>
                                        <a href="#" class="button-delete" onclick="del_questions('[! $v["id"] !]')">刪除</a>
                                    </div>
                                    <table id="table-data">
                                        <tr>
                                            <th>試題SN</th><td>26452</td>
                                        </tr>
                                        <tr>
                                            <th>建構題</th><td>類型86</td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

                <div class="form-button-wrap">
                    <input class="btn-yellow" type="submit" value="選擇完畢，送出" />
                </div>
            </form>
        </div>
    </div>
</div>
[! Html::script('js/jquery-1.11.3.js') !]
<script>
    //移除 一個試卷資料
    function del_exampaper()
    {
        if(confirm("確定是否刪除試卷及所屬的試題嗎?")){
            $.ajax({
                url: "[! route('ad.exampaper.delete') !]",
                type:'POST',
                data: {
                    _token: '[! csrf_token() !]',
                    getID: '[! $exampaper_id !]'
                },
                error: function(xhr) {
                    //alert('Ajax request 發生錯誤');
                },
                success: function(response) {
                    alert('試卷刪除成功!!');
                    location.href = "[! route('ad.exampaper.vol.list.page') !]";
                }
            });
        }
    }

    //移除 一個試題資料
    function del_questions(id)
    {
        if(confirm("確定是否刪除試題嗎?")){
            $.ajax({
                url: "[! route('ad.questions.delete') !]",
                type:'POST',
                data: {
                    _token: '[! csrf_token() !]',
                    exam_paper_id: '[! $exampaper_id !]',
                    id: id
                },
                error: function(xhr) {
                    //alert('Ajax request 發生錯誤');
                },
                success: function(response) {
                    alert('試題刪除成功!!');
                    location.reload();
                }
            });
        }
    }
</script>
@stop