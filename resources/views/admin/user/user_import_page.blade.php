@extends('admin.layout.layout')
@section('content')
    <div id="page-container">
    <div id="page-body">
        <h1 class="section-title title-usermange">使用者管理</h1>
        <div class="record-wrap clearfix">
            <div class="record-menu">
                <ul>
                    <li><a href="[! route('ad.school.list') !]" tittle="學校管理">學校管理</a></li>
                    <li><a href="[! route('ad.user.add.page') !]" title="新增使用者">新增使用者</a></li>
                    <li><a class="active" href="[! route('ad.user.import.page') !]" tittle="匯入使用者">匯入使用者</a></li>
                    <li><a href="#" title="查詢使用者資料">查詢使用者資料</a></li>
                </ul>
            </div>
            <div class="record-content">
                <form id="addschool-form">
                    <div class="title-feature">匯入使用者<span class="tip">有<span class="star">*</span>的欄位不可空白</span></div>
                    <div class="record-inner">
                        <div class="select-group">
                            <div class="label-title label-title-s">班級</div>
                            <select class="select-s" id="city_code" onchange="get_city_school()">
                                @foreach($city_data as $k => $v)
                                    <option value="[! $k !]" >[! $v !]</option>
                                @endforeach
                            </select>
                            <select class="select-s" id="organization_id">
                                <option value="學校名稱">學校名稱</option>
                            </select>
                            <select class="select-s" id="grade">
                                @for($x=1;$x<21;$x++)
                                    <option value="[! $x !]">[! $x !]年級</option>
                                @endfor
                            </select>
                            <select class="select-s" id="class">
                                @for($x=1;$x<21;$x++)
                                    <option value="[! $x !]">[! $x !]班級</option>
                                @endfor
                            </select>
                        </div>
                        <div class="select-group">
                            <div class="label-title label-title-s">身份</div>
                            <select>
                                <option value="學生">學生</option>
                            </select>
                        </div>
                        <div class="select-group">
                            <div class="label-title"><span class="txt-red">*</span>EXCEL 檔案</div>
                            <input type="file" accept=".xls,.xlsx">
                        </div>
                        <div class="example-wrap">
                            <p>說明：</p>
                            <p>1.利用 excel 或其他工具鍵入學生資料，存成 xls 檔（xlsx檔案格式不接受），並保留第一列標題檔，如 <a class="example-file" href="#">範例檔</a>。</p>
                            <p>2.匯入前先選取帳號之身份、班級。</p>
                            <p>3.本功能適用「同學校、同班級」帳號之匯入。</p>
                        </div>
                        <div class="form-button-wrap">
                            <input class="btn-yellow" type="submit" value="開始匯入" />
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
[! Html::script('js/jquery-1.11.3.js') !]
<script>
    var school_data = [];
    @foreach($all_school as $v)
        school_data.push(
        {
            'organization_id':'[! $v['organization_id'] !]',
            'name':'[! $v['name'] !]',
            'city_code':'[! $v['city_code'] !]',
        }
        );
    @endforeach

    $( document ).ready(function() {
        //重新設定學校資料
        get_city_school();
    });

    /**
     * 回傳指定縣市的學校
     */
    function get_city_school()
    {
        $("#organization_id option").remove();
        var city_code_value = $('#city_code').val();
        var total_school_num =  school_data.length;
        for(var x=0;x < total_school_num;x++)
        {
            if(school_data[x]['city_code'] == city_code_value)
            {
                $("#organization_id").append($("<option></option>").attr("value", school_data[x]['organization_id']).text(school_data[x]['name']));
            }
        }
    }
</script>
@stop