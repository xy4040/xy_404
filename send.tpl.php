<?php defined('IN_YuLin') || exit('NO PERMIT!'); ?>
{template index/header}
    <div class="subnav">
        <a href="">首页</a> &gt; <a href="">活动管理</a> &gt; <a href="">发送活动</a>
    </div>
    <script src="http://www.qipai101.com/lib/ueditor/ueditor.config.js"></script>
    <script src="http://www.qipai101.com/lib/ueditor/ueditor.all.min.js"></script>
    <script src="http://www.qipai101.com/lib/ueditor/lang/zh-cn/zh-cn.js"></script>
    <div class="main-inner">
        <div class="x-body">
            <div class="form-box">
                <form action="" method="post" id="myform">
                    <ul>
                        <li><label for="">活动名称</label><input type="text" name="a-name" class="a-name"></li>
                        <li class="tab"><span class="c-blue">PC</span><span>Mobile</span></li>
                        <div class="box-lists">
                            <li><label for="">活动简介</label><input type="text" name="a-summary"> *活动简介最多展示40个字符</li>
                            <li class="a-pic">
                                <label for="">活动标图</label><input type="text" class="thumbTip" readonly="readonly">
                                <span style="position: relative;">
                                    上传
                                    <input  id="uploadPic" style="opacity: 0; position: absolute; left: 0; width: 60px;" type="file" accept="image/*" >
                                </span>
                                <span>删除</span>
                                <span>图片预览</span>
                            </li>
                            <li>
                                <label for="">使用图片</label>
                                <div class="choose-box">
                                    <p>否</p>
                                </div>
                            </li>
                            <li style="height: 420px;">
                                <label for="">内容描述</label>
                                <div class="richTxt" style="float: left">
                                    <script id="editor_content" name="content" type="text/plain" style="width:95%;height:300px;"></script><script type="text/javascript">var _ue = UE.getEditor("editor_content");</script>
                                </div>
                            </li>
                            <li class="Btns"><a class="sendBtn">提交保存</a> <a href="?m={$m}&c={$c}">返回</a></li>
                        </div>
                    </ul>
                </form>
            </div>
        </div>
    </div>
    <style>
    *{padding: 0; margin: 0;}
    .main-inner{ border: 1px solid #f0f0f0; }
    .form-box form ul li{ display: block; height: 35px; line-height: 35px;clear: both; margin: 10px 0; }
    .form-box form ul li label{ display: block; float: left; width: 80px; text-align: right; margin-right: 10px; }
    .form-box form ul li label:before{ content: "*"; display: inline-block; color: red; padding-right: 5px;line-height: 35px;}
    .form-box form ul li input{ width: 300px; height: 30px; border: 1px solid #ccc; }
    .form-box .richTxt{ float: left; }

    .form-box form .tab{ margin: 10px 0; padding-left: 12px; margin-bottom: 0; position: relative; top: 1px; background: #fff; width: 170px;}
    .form-box form .tab span{ display: inline-block;float: left; padding: 0 25px; border-top: 1px solid #f0f0f0; cursor: pointer;border-left: 1px solid #f0f0f0; border-bottom: 1px solid #f0f0f0; }
    .form-box form .tab span:nth-child(2){ border-right: 1px solid #f0f0f0; }
    .box-lists{ border: 1px solid #f0f0f0; margin-left: 12px; padding-left: 10px; }
    .c-blue{ color: blue; border-bottom: none !important; }
    .a-pic span{ padding: 5px 12px; border:1px solid #ccc; margin: 0 5px; cursor: pointer; border-radius: 3px; }
    .a-pic .thumbTip{ background: #ccc; }

    .choose-box{ background: #ccc; width: 80px; float: left; border: 1px solid #ccc; height: 30px; cursor: pointer; }
    .choose-box p{ width: 38px; background: #fff; padding: 1px; height: 28px; text-align: center; line-height: 28px;}
    .choose-box.c-col{ background: #03a9f4; }
    .Btns{ height: 35px; line-height: 35px; }
    .sendBtn{ background: #03a9f4; color: #fff; display: inline-block; padding: 0 12px; margin-right: 15px; border-radius: 3px; cursor: pointer;}
    </style>
    <script>
    $(function(){
        // 选项卡
        $(".tab span").on('click',function(){
            if(!$(this).hasClass('c-blue')){
                $(this).addClass('c-blue').siblings().removeClass('c-blue');
            }
        })

        $(".choose-box").on('click',function(){
            if(!$(this).hasClass('c-col')){
                $(this).addClass('c-col');
                $(this).find('p').css('transform','translateX(40px)').html('是');
            }else{
                $(this).removeClass('c-col');
                $(this).find('p').css('transform','translateX(0px)').html('否');
            }
        })

        $("#uploadPic").on("change",function(){
            $(".thumbTip").val($(this).val());
        });

        $(".sendBtn").on('click',function(){
            var oUrl = '?m={$m}&c={$c}&a={$a}&o=1';
            var title = $(".a-name").val(), scoure = $(".tab .c-blue").html(), contents = $("#editor_content").val() || 'test';
            $.post(oUrl,{title:title,scoure:scoure,contents:contents},function(res){
                res = eval('('+res+')');
                console.log(res);
            });
        });
    });
    </script>
{template index/footer}
