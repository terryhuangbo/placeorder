/**
 * Created by Qingwenjie on 2015/11/13.
 */
_prefix_form_code = '<form action="" method="post" class="form-horizontal" id="_submit_form" enctype="multipart/form-data" target="loading">' +
'<div class="form-group form-group-sm"><label class="col-sm-2 control-label label-title">位置ID：</label>' +
'<div class="col-sm-6"><input type="text" class="form-control" value="<!--[widget_id]-->-<!--[p_id]-->" disabled></div>' +
'</div>';
_form_list = {
    'word': '<div class="form-group form-group-sm">' +
    '<label class="col-sm-2 control-label label-title"><!--[tips]-->：</label>' +
    '<div class="col-sm-6"><input type="text" class="form-control" name="data[<!--[name]-->]" value="{<!--[name]-->}"></div>' +
    '</div>',
    'image': '<div class="form-group form-group-sm">' +
    '<label class="col-sm-2 control-label label-title"><!--[tips]-->：</label>' +
    '<div class="col-sm-8"><input type="text" class="form-control" id="_get_upfile_review" disabled="disabled" value="{<!--[name]-->}" /> ' +
    '<input type="hidden" class="form-control" id="_upload_callback_input" name="data[<!--[name]-->]" value="{<!--[name]-->}" /> ' +
    '<a href="{<!--[name]-->}" target="_blank" id="_a_upfile_review">预览</a></div>' +
    '</div>',
    'link': '<div class="form-group form-group-sm">' +
    '<label class="col-sm-2 control-label label-title"><!--[tips]-->：</label>' +
    '<div class="col-sm-8"><input type="text" class="form-control" name="data[<!--[name]-->]" value="{<!--[name]-->}"></div>' +
    '</div>' +
    '<div class="form-group form-group-sm">' +
    '<label class="col-sm-2 control-label label-title">新窗口打开：</label>' +
    '<div class="checkbox col-sm-8"><label><input type="checkbox" {target} name="data[target]" value="_blank" />是</label></div>' +
    '</div>',
    'textarea': '<div class="form-group form-group-sm">' +
    '<label class="col-sm-2 control-label label-title"><!--[tips]-->：</label>' +
    '<div class="col-sm-8"><textarea class="form-control" name="data[<!--[name]-->]" rows="6">{<!--[name]-->}</textarea></div>' +
    '</div>',
    'date': '<div class="form-group form-group-sm">' +
    '<label class="col-sm-2 control-label label-title"><!--[tips]-->：</label>' +
    '<div class="col-sm-2"><input type="text" class="form-control _bui_date" name="data[<!--[name]-->]" value="{<!--[name]-->}" /></div> ' +
    '</div>'
};
_end_form_code = '<div class="form-group form-group-sm">' +
'<label class="col-sm-2" for="formGroupInputSmall">&nbsp;' +
'<input type="hidden" name="data[push_id]" value="<!--[push_id]-->" />' +
'<input type="hidden" name="data[widget_id]" value="<!--[widget_id]-->" />' +
'<input type="hidden" name="data[p_id]" value="<!--[p_id]-->" />' +
'<input type="hidden" name="data[r_id]" value="<!--[r_id]-->" />' +
'</label>' +
'<div class="col-sm-8"><input type="submit" class="_save_form_data btn btn-primary" value="保存" /></div>' +
'</div>' +
'</form>';
$(function () {
    $(document).find('a').removeAttr('target').off('click');
    //新窗口打开指定链接
    $(document).find('._add_blank').each(function () {
        $(this).attr('target', '_blank');
    });
    //小模块排序
    $('._page_edit_box').sortable({
        tolerance: 'move',
        placeholder: "holder_box",
        distance: 20,
        //revert: true,
        //cancel: 'a',
        update: function (event, ui) {
            sort_data = '';
            $(document).find('.s_module_edit_box').each(function (i) {
                sort_data += $(this).attr('widget_id') + '|';
            });
            _ajax('/push/personal/ajax_save_widget_sort', {sort_data: sort_data}, 'post', 'json', function (d) {
            });
        }
    });
    //清空页面所有模块数据
    $('#clear_page_module').click(function () {
        if (confirm('清空后无法恢复，该操作实时生效，确认要操作？')) {
            _ajax('/push/personal/ajax_del_page_code', '', 'get', 'json', function (d) {
                if (d.ret == '0001') {
                    _show_tips_win('#_tips_win', '提示窗口', '操作成功！', 3, '');
                    setTimeout(function () {
                        window.location.href = '/push/personal/index';
                    }, 3000)
                }
                else {
                    _show_tips_win('#_tips_win', '提示窗口', '操作失败！', 3, '');
                }
            });
        }
    });
    //初始化默认 数据编辑模式
    _data_edit_mode();
    //框架编辑模式
    $(document).on('click', '#_module_edit_mode', function () {
        _frame_edit_mode();
    });
    //数据编辑模式
    $(document).on('click', '#_data_edit_mode', function () {
        _data_edit_mode();
    });
});
function _frame_edit_mode() {
    $('._page_edit_box').sortable('enable');
    $('._module_edit_box').remove();
    $('._s_edit_box').remove();
    $('.s_module_edit_box').addClass('cursor-move');
    //解除数据编辑绑定事件
    $(document).off('click', '._page_edit');
    $(document).off('click', '._s_module_del');
    $(document).off('click', '._module_clear');
    $(document).off('click', '._module_operation');
    $(document).off('click', '.module_list');
    //遍历节点增加编辑菜单
    $(document).find('._page_edit_box').each(function (k, v) {
        //显示数据编辑编辑窗口
        var module_edit_html = '<span class="_module_edit_box">' +
            '<h2>框架操作：</h2>' +
            '<a href="javascript:void(0);" class="btn btn-primary _module_operation">【添加模块】</a>' +
            '<a href="javascript:void(0);" class="btn btn-primary _module_clear">【清空框架】</a>' +
            '</span>';
        $(this).append(module_edit_html);
    });
    //遍历节点增加编辑菜单
    $(document).find('.s_module_edit_box').each(function (k, v) {
        var _s_module_edit_html = '<span class="_s_edit_box">' +
            '<h2>模块操作：</h2>' +
            '<a href="javascript:void(0);" class="btn btn-primary _s_module_del">【删除模块】</a>' +
            '</span>';
        $(this).append(_s_module_edit_html);
    });
    //添加模块
    $(document).on('click', '._module_operation', function () {
        var r_id = $(this).parents('._page_edit_box').attr('r_id');
        if (r_id) {
            //存储正在编辑模块的标识
            $('#e_r_id').attr('e_r_id', r_id);
            //填充表单数据
            _get_module_list(r_id, function (d) {
                if (d.ret == '0001') {
                    if (d.data) {
                        code = '';
                        $.each(d.data, function (k, v) {
                            code += '<li class="module_list" m_id="' + v.id + '">' + v.name + '</li>';
                        });
                    }
                    _show_tips_win('#_tips_win', '点击选择模块', code, 0, '');
                }
            });
        }
    });
    //清除模块
    $(document).on('click', '._module_clear', function () {
        var _this_f_dom = $(this).parent().parent();
        var r_id = _this_f_dom.attr('r_id');
        if (confirm('确定要清空当前框架下的所有模块？')) {
            _ajax('/push/personal/ajax_del_widget_data', {r_id: r_id}, 'get', 'json', function (d) {
                if (d.ret == '0001') {
                    _this_f_dom.html('');
                    _show_tips_win('#_tips_win', '提示窗口', '清除成功！', 3, '');
                }
                else {
                    _show_tips_win('#_tips_win', '提示窗口', '清除失败！', 0, '');
                }
            });
        }
    });
    //新增模块
    $(document).on('click', '.module_list', function () {
        m_id = $(this).attr('m_id');
        _get_module_info(m_id, function (d) {
            if (d.ret == '0001') {
                var e_r_id = $('#e_r_id').attr('e_r_id');
                _ajax('/push/personal/ajax_save_widget_data', {
                    r_id: e_r_id,
                    m_id: m_id
                }, 'get', 'json', function (data) {
                    if (data.ret == '0001') {
                        //插入代码
                        $(document).find('._page_edit_box').each(function (k, v) {
                            if ($(this).attr('r_id') == e_r_id) {
                                $(this).append(data.data);
                                //关闭弹框
                                _close_win('#_tips_win');
                            }
                        });
                    }
                    else {
                        _show_tips_win('#_tips_win', '提示窗口', '添加失败！', 3, '');
                    }
                });
            }
        });
    });
    //删除小模块
    $(document).on('click', '._s_module_del', function () {
        var _this_f_dom = $(this).parent().parent();
        var widget_id = _this_f_dom.attr('widget_id');
        if (confirm('确定要删除？')) {
            _ajax('/push/personal/ajax_del_widget_data', {widget_id: widget_id}, 'get', 'json', function (d) {
                if (d.ret == '0001') {
                    _this_f_dom.remove();
                    _show_tips_win('#_tips_win', '提示窗口', '删除成功！', 3, '');
                }
                else {
                    _show_tips_win('#_tips_win', '提示窗口', '删除失败，请稍后重试！', 3, '');
                }
            });
        }
    });
    //修改显示状态
    $('#_now_edit_mode').html('框架编辑');
}
//数据编辑模式
function _data_edit_mode() {
    //解除绑定事件
    $(document).off('click', '._page_edit');
    $(document).off('click', '#myTab a');
    $(document).off('click', '._del_push_info');
    $(document).off('click', '._edit_push_info');
    $(document).off('click', '._save_form_data');
    $(document).off('click', '._del_push_info');
    $(document).off('click', '._edit_push_info');
    //TAB切换效果
    $(document).on('click', '#myTab a', function (e) {
        e.preventDefault();
        var _this_data = $(this).attr('data');
        $('#' + _this_data).siblings().removeClass('tab-active').addClass('tab-hide');
        $('#' + _this_data).removeClass('hide').addClass('tab-active');
    });
    //删除推送数据
    $(document).on('click', '._del_push_info', function () {
        var push_id = $(this).attr('push_id');
        if (push_id && confirm('删除后无法恢复，确定要删除？')) {
            _ajax('/push/personal/ajax_del_push_info', {push_id: push_id}, 'get', 'json', function (d) {
                if (d.ret == '0001') {
                    _show_tips_win('#_tips_win', '提示窗口', '删除成功！', 3, '');
                }
                else {
                    _show_tips_win('#_tips_win', '提示窗口', '删除失败！', 3, '');
                }
            });
        }
    });
    //移除拖拽效果
    $('._page_edit_box').sortable('disable');
    $('._module_edit_box').remove();
    $('._s_edit_box').remove();
    $('.s_module_edit_box').removeClass('cursor-move');
    //取消页面所有A链接的点击事件
    $(document).find('._page_edit').each(function () {
        $(this).css({cursor: 'pointer'}).attr({'title': '点击配置该位置参数', 'alt': '点击配置该位置参数'});
    });
    //获取点击事件，获取参数，分发至各个处理方法
    $(document).on('click', '._page_edit', function () {
        _get_form_code($(this), function (edit_form_code, p_id, widget_id, _page_form_type, _r_id, _page_form_type_string) {
            _ajax('/push/personal/ajax_get_push_list', {
                p_id: p_id,
                widget_id: widget_id
            }, 'get', 'json', function (d) {
                table_title = '<th>ID</th>';
                //获取表头
                if (_page_form_type != '') {
                    $.each(_page_form_type, function (k, v) {
                        table_title += '<th>' + v.tips + '</th>';
                    });
                }
                table_title += '<th>添加时间</th><th>操作</th>';
                history_code = '';
                if (d.ret == '0001' && d.data != '') {
                    if (d.data) {
                        $.each(d.data, function (k, v) {
                            history_code += '<tr><td>' + v.push_id + '</td>';
                            var content_obj = eval('(' + v.content + ')');
                            if (content_obj != '') {
                                $.each(content_obj, function (kk, vv) {
                                    if (kk == 'image') {
                                        history_code += '<td><img src="' + vv + '" width="120px" height="40px" /></td>';
                                    }
                                    else if (kk != 'target') {
                                        history_code += '<td title="' + vv + '">' + subString(vv, 30, '...') + '</td>';
                                    }
                                });
                            }
                            else {
                                history_code += '无数据';
                            }
                            history_code += '<td>' + _time_to_string(v.create_time) + '</td>' +
                            '<td>' +
                            '<a href="javascript:void(0);" class="_edit_push_info" push_id="' + v.push_id + '" p_id="' + p_id + '" widget_id="' + widget_id + '" page_form_type="' + _page_form_type_string + '" r_id="' + _r_id + '">[修改]</a> ' +
                            '<a href="javascript:void(0);" class="_del_push_info" push_id="' + v.push_id + '">[删除]</a>' +
                            '</td>' +
                            '</tr>';
                        });
                    }
                }
                else {
                    history_code += '<tr><td colspan="15">暂无数据！</td></tr>';
                }
                var page_code;
                if (typeof(d._page_code) == "undefined") {
                    page_code = '';
                }
                else {
                    page_code = d._page_code;
                }
                var tab_code = '<ul id="myTab" class="nav nav-tabs">' +
                    '<li class="active"><a data-toggle="tab" id="home-tab" data="edit_form" href="#edit_form">数据</a></li>' +
                    '<li><a data-toggle="tab" role="tab" id="profile-tab" data="history" href="#history">历史记录</a></li>' +
                    '</ul>' +
                    '<div id="myTabContent">' +
                    '<div class="active" id="edit_form">' + edit_form_code + '</div>' +
                    '<div class="hide" id="history">' +
                    '<table class="table">' +
                    '<thead><tr>' + table_title + '</tr></thead>' +
                    '<tbody id="_history_info_list">' + history_code +
                    '</tbody>' +
                    '</table>' +
                    '<div id="_history_info_list_page">' + page_code + '</div>' +
                    '</div>' +
                    '</div>';
                _show_tips_win('#_tips_win', '数据配置', tab_code, 0, '');
                //绑定分页事件
                $(document).on('click', '.pagination > li > a', function () {
                    var _link = $(this).attr('href');
                    if (_link !== 'javascript:void(0);') {
                        _get_form_push_list(_link, function (data) {
                            history_list = '';
                            if (data.ret == '0001' && data.data != '') {
                                $.each(data.data, function (k, v) {
                                    history_list += '<tr><td>' + v.push_id + '</td>';
                                    var content_obj = eval('(' + v.content + ')');
                                    if (content_obj != '') {
                                        $.each(content_obj, function (kk, vv) {
                                            if (kk == 'image') {
                                                history_list += '<td><img src="' + vv + '" width="80px" height="40px" /></td>';
                                            }
                                            else if (kk != 'target') {
                                                history_list += '<td>' + vv + '</td>';
                                            }
                                        });
                                    }
                                    else {
                                        history_list += '无数据';
                                    }
                                    history_list += '<td>' + _time_to_string(v.create_time) + '</td>' +
                                    '<td><a href="javascript:void(0);" class="_edit_push_info" push_id="' + v.push_id + '" p_id="' + p_id + '" widget_id="' + widget_id + '" page_form_type="' + _page_form_type_string + '" r_id="' + _r_id + '">[修改]</a> ' +
                                    '<a href="javascript:void(0);" class="_del_push_info" push_id="' + v.push_id + '">[删除]</a></td>' +
                                    '</tr>';
                                });
                            }
                            else {
                                history_list += '<tr><td colspan="15">暂无数据！</td></tr>';
                            }
                            $('#_history_info_list').html(history_list);
                            $('#_history_info_list_page').html(data._page_code);
                        });
                    }
                    return false;
                });
                $(document).off('click', '._save_form_data');
                $(document).on('click', '._save_form_data', function () {
                    $('#_submit_form').ajaxSubmit({
                        url: '/push/personal/ajax_save_push_info',
                        data: $(this).serialize(),
                        cache: false,
                        type: "POST",
                        dataType: 'json',
                        beforeSubmit: function () {
                        },
                        success: function (data) {
                            if (data.ret == '0001') {
                                _show_tips_win('#_tips_win', '数据配置', '操作成功', 3, function () {
                                    refresh_s_module_code(widget_id, data.data);
                                });
                            }
                            else {
                                _show_tips_win('#_tips_win', '数据配置', '操作失败', 3, '');
                            }
                        }
                    });
                    return false;
                });
                //时间选择器
                BUI.use('bui/calendar', function (Calendar) {
                    var startPicker = new Calendar.DatePicker({
                        trigger: '._bui_date',
                        showTime: true,
                        autoRender: true,
                        dateMask: 'yyyy-mm-dd'
                    });
                });
            });
        });
        return false;
    });
    $(document).on('click', '._edit_push_info', function () {
        _get_form_edit_code($(this), function (edit_form_code) {
            $('#edit_form').html(edit_form_code);
            //切换tab
            $('#myTab a[href="#edit_form"]').tab('show');
            $('#edit_form').siblings().removeClass('tab-active').addClass('tab-hide');
            $('#edit_form').removeClass('hide').addClass('tab-active');
            //时间选择器
            BUI.use('bui/calendar', function (Calendar) {
                var startPicker = new Calendar.DatePicker({
                    trigger: '._bui_date',
                    showTime: true,
                    autoRender: true,
                    dateMask: 'yyyy-mm-dd'
                });
            });
        });
    });
    //修改显示状态
    $('#_now_edit_mode').html('数据编辑');
}
//获取历史数据
function _get_form_push_list(link, callBackFun) {
    if (link) {
        _ajax(link, {}, 'get', 'json', function (d) {
            if (typeof(callBackFun) == "function") {
                callBackFun(d);
            }
        });
    }
}
//获取表单代码
function _get_form_code(_this_dom, callBackFun) {
    //分析参数配置
    _p_id = _this_dom.attr('_p_id');
    _page_form_type = eval('(' + _this_dom.attr('_page_form_type') + ')');
    _page_form_type_string = _this_dom.attr('_page_form_type');
    _widget_id = _this_dom.parents('.s_module_edit_box').attr('widget_id');//获取挂件ID
    _r_id = _this_dom.parents('._page_edit_box').attr('r_id');//获取挂件ID
    _form_code = '';
    _image_size_desc = '';
    _has_image = false;
    $.each(_page_form_type, function (k, v) {
        if (v != '') {
            var _this_code = _form_list[v.type];
            $.each(v, function (kk, vv) {
                _this_code = _this_code.replace(eval('/<!--\\[' + kk + '\\]-->/g'), vv);
                if (vv == 'image') {
                    _has_image = true;
                }
            });
            if(_has_image && typeof(v.size_desc) != 'undefined' && v.size_desc != ''){
                _image_size_desc = v.size_desc;
            }
            _form_code += _this_code;
        }
        else {
            _form_code += _form_list[v.type];
        }
    });
    edit_form_code = _prefix_form_code + _form_code + _end_form_code;
    if (_has_image) {
        edit_form_code = _create_file_upload_form(_image_size_desc) + edit_form_code;
    }
    if (_widget_id && _p_id) {
        //替换挂件ID和位置ID
        edit_form_code = edit_form_code.replace(/<!--\[widget_id\]-->/g, _widget_id).replace(/<!--\[p_id\]-->/g, _p_id).replace(/<!--\[r_id\]-->/g, _r_id);
    }
    else {
        _close_win('#_tips_win');
        _show_tips_win('#_tips_win', '数据配置', '参数不完整！', 0);
        return;
    }
    //替换空数据标签
    edit_form_code = edit_form_code.replace(/<!--\[\w+\]-->/g, '').replace(/{\w+}/g, '');
    if (typeof (callBackFun) == "function") {
        callBackFun(edit_form_code, _p_id, _widget_id, _page_form_type, _r_id, _page_form_type_string);
    }
}
//获取编辑推送信息表单
function _get_form_edit_code(dom, callBackFun) {
    _p_id = dom.attr('p_id');
    _r_id = dom.attr('r_id');
    _page_form_type = eval('(' + dom.attr('page_form_type') + ')');
    _widget_id = dom.attr('widget_id');
    _push_id = dom.attr('push_id');
    _form_code = '';
    _image_size_desc = '';
    _has_image = false;
    $.each(_page_form_type, function (k, v) {
        if (v != '') {
            var _this_code = _form_list[v.type];
            $.each(v, function (kk, vv) {
                _this_code = _this_code.replace(eval('/<!--\\[' + kk + '\\]-->/g'), vv);
                if (vv == 'image') {
                    _has_image = true;
                }
            });
            if(_has_image && typeof(v.size_desc) != 'undefined' && v.size_desc != ''){
                _image_size_desc = v.size_desc;
            }
            _form_code += _this_code;
        }
        else {
            _form_code += _form_list[v.type];
        }
    });
    edit_form_code = _prefix_form_code + _form_code + _end_form_code;
    if (_widget_id && _p_id) {
        //替换挂件ID和位置ID
        edit_form_code = edit_form_code.replace(/<!--\[widget_id\]-->/g, _widget_id).replace(/<!--\[p_id\]-->/g, _p_id);
    }
    else {
        _close_win('#_tips_win');
        _show_tips_win('#_tips_win', '数据配置', '参数不完整！', 0);
        return;
    }
    //替换表单数据
    _ajax_get_push_data(_push_id, _p_id, _widget_id, function (data) {
        if (data.ret == '0001' && data.data.content) {
            if (data.data.content.target == '_blank') {
                edit_form_code = edit_form_code.replace(/\{target\}/g, ' checked="checked" ');
            }
            $.each(data.data.content, function (k, v) {
                edit_form_code = edit_form_code.replace(eval('/{' + k + '}/g'), v);
            });
            //替换推送信息ID,用于判断是修改还是添加
            edit_form_code = edit_form_code.replace(/<!--\[push_id\]-->/g, data.data.push_id);
        }
        //替换空标签
        edit_form_code = edit_form_code.replace(/<!--\[r_id\]-->/g, _r_id).replace(/<!--\[\w+\]-->/g, '');
        if (_has_image) {
            edit_form_code = _create_file_upload_form(_image_size_desc) + edit_form_code;
        }
        //替换空数据标签
        edit_form_code = edit_form_code.replace(/{\w+}/g, '');
        if (typeof (callBackFun) == "function") {
            callBackFun(edit_form_code);
        }
    });
}
//获取推送位数据
function _ajax_get_push_data(push_id, p_id, widget_id, callBackFun) {
    if (p_id) {
        _ajax('/push/personal/ajax_get_push_info', {
            push_id: push_id,
            p_id: p_id,
            widget_id: widget_id
        }, 'get', 'json', function (d) {
            if (typeof (callBackFun) == "function") {
                callBackFun(d);
            }
        });
    }
}
//获取模块列表
function _get_module_list(gid, callBackFun) {
    if (gid) {
        $.ajax({
            url: '/push/personal/ajax_get_module_list',
            data: {gid: gid},
            cache: false,
            type: "get",
            dataType: 'json',
            error: function () {
            },
            success: function (d) {
                if (typeof (callBackFun) == "function") {
                    callBackFun(d);
                }
            }
        });
    }
}
//获取模块信息
function _get_module_info(mid, callBackFun) {
    if (mid) {
        $.ajax({
            url: '/push/personal/ajax_get_module_info',
            data: {mid: mid},
            cache: false,
            type: "get",
            dataType: 'json',
            error: function () {
            },
            success: function (d) {
                if (typeof (callBackFun) == "function") {
                    callBackFun(d);
                }
            }
        });
    }
}
//生成上传表单
function _create_file_upload_form(__size_tips__) {
    return '<iframe src="" id="loading" name="loading" style="display: none" width="100px" height="100px"></iframe>' +
        '<form name="upload" id="upload" class="upload_form form-horizontal" method="POST" enctype="multipart/form-data" action="' + _UPLOAD_URL + '" target="loading">' +
        '<div class="form-group form-group-sm mt10"><label class="col-sm-4 control-label label-title">选择图片 (' + __size_tips__ + ')：</label>' +
        '<div class="col-sm-6"><input type="file" name="attachment" class="attachment">' +
        '<input type="hidden" name="callback" value="' + _BACKEND_URL + '/push/info/upload_file_callback?1=1">' +
        '<input type="hidden" name="username" value="' + _USERNAME + '">' +
        '<input type="hidden" name="objtype" value="rc">' +
        '<input type="hidden" name="appid" value="vsomaker">' +
        '<input type="hidden" name="token" value="vsomaker">' +
        '<input type="button" class="btn btn-primary" id="fileuploadbt" value="上传" onclick="return uploadfile($(this));"/> ' +
        '<span class="_up_status"></span>' +
        '</div></div>' +
        '</form>';
}
//跨域上传文件
function uploadfile(this_dom) {
    if (this_dom.siblings('.attachment').val() == '') {
        return false;
    }
    jQuery("#upload").submit();
}
//上传回调函数
function setfileurlfromcallback(fileurl) {
    $("#_get_upfile_review, #_upload_callback_input").val(fileurl);
    $("#_a_upfile_review").attr('href', fileurl);
    $("._up_status").html('上传完毕');
}
//ajax请求
function _ajax(url, data, type, datatype, callBackFun) {
    if (url) {
        $.ajax({
            url: url,
            data: data,
            cache: false,
            type: type,
            dataType: datatype,
            error: function () {
            },
            success: function (d) {
                if (typeof (callBackFun) == "function") {
                    callBackFun(d);
                }
            }
        });
    }
}
//提示窗口
function _show_tips_win(dom_name, title, msg, timeout, callBackFun) {
    if (!title) {
        title = '提示窗口';
    }
    $(dom_name).find('.modal-title').html(title);
    $(dom_name).find('#_tips_content').html(msg);
    $(dom_name).modal({backdrop: 'static', keyboard: false});
    if (timeout > 0) {
        setTimeout(function () {
            _close_win(dom_name);
            if (typeof (callBackFun) == "function") {
                callBackFun();
            }
        }, parseInt(timeout) * 1000);
    }
}
//关闭窗口
function _close_win(dom_name) {
    $(dom_name).modal('hide');
}
//时间戳转字符串
function _time_to_string(timestamp) {
    var d = new Date(timestamp * 1000);    //根据时间戳生成的时间对象
    return (d.getFullYear()) + "-" +
        (d.getMonth() + 1) + "-" +
        (d.getDate()) + " " +
        (d.getHours()) + ":" +
        (d.getMinutes()) + ":" +
        (d.getSeconds());
}
//截取字符串 包含中文
function subString(str, len, hasDot) {
    var newLength = 0;
    var newStr = "";
    var chineseRegex = /[^\x00-\xff]/g;
    var singleChar = "";
    var strLength = str.replace(chineseRegex, "**").length;
    for (var i = 0; i < strLength; i++) {
        singleChar = str.charAt(i).toString();
        if (singleChar.match(chineseRegex) != null) {
            newLength += 2;
        }
        else {
            newLength++;
        }
        if (newLength > len) {
            break;
        }
        newStr += singleChar;
    }
    if (hasDot && strLength > len) {
        newStr += "...";
    }
    return newStr;
}
//刷新小模块代码
function refresh_s_module_code(widget_id, code) {
    if (widget_id && code) {
        $(document).find('.s_module_edit_box').each(function () {
            if ($(this).attr('widget_id') == widget_id) {
                var _this_parent_dom = $(this).parent();
                $(this).replaceWith(code);
                _this_parent_dom.find('._page_edit').each(function () {
                    $(this).css({cursor: 'pointer'}).attr({'title': '点击配置该位置参数', 'alt': '点击配置该位置参数'});
                });
                return false;
            }
        });
    }
}