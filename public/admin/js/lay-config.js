/**
 * date:2019/08/16
 * author:Mr.Chung
 * description:此处放layui自定义扩展
 * version:2.0.4
 */

window.rootPath = (function (src) {
    src = document.scripts[document.scripts.length - 1].src;
    return src.substring(0, src.lastIndexOf("/") + 1);
})();

layui.config({
    base: rootPath + "lay-module/",
    version: true
}).extend({
    miniAdmin: "layuimini/miniAdmin", // layuimini后台扩展
    miniMenu: "layuimini/miniMenu", // layuimini菜单扩展
    miniTab: "layuimini/miniTab", // layuimini tab扩展
    miniTheme: "layuimini/miniTheme", // layuimini 主题扩展
    miniTongji: "layuimini/miniTongji", // layuimini 统计扩展
    step: 'step-lay/step', // 分步表单扩展
    treetable: 'treetable-lay/treetable', //table树形扩展
    treeTable: 'treeTable-v3/treeTable', // https://gitee.com/whvse/treetable-lay v3.0
    tableSelect: 'tableSelect/tableSelect', // table选择扩展
    iconPickerFa: 'iconPicker/iconPickerFa', // fa图标选择扩展
    echarts: 'echarts/echarts', // echarts图表扩展
    echartsTheme: 'echarts/echartsTheme', // echarts图表主题扩展
    wangEditor: 'wangEditor/wangEditor', // wangEditor富文本扩展
    layarea: 'layarea/layarea', //  省市县区三级联动下拉选择器
});

layui.$.ajaxSetup({
    headers: {
        'Accept': 'application/json'
    },
    error: function (jqXHR, textStatus, errorThrown) {
        switch (jqXHR.status) {
            case (500):
                layer.alert('服务器系统内部错误', {
                    icon: 2
                });
                break;
            case (401):
                console.log(new Date())
                layer.msg('您暂未登录或已掉线，请重新登录', {
                    icon: 2,
                    time: 1000,
                }, function (index) {
                    console.log(new Date())
                    window.location = '/admin/page/login.html';
                });
                break;
            case (403):
                layer.alert('无权限执行此操作', {
                    icon: 2
                });
                break;
            case (408):
                layer.alert('请求超时', {
                    icon: 2
                });
                break;
            default:
                layer.alert('未知错误,请联系管理员', {
                    icon: 2
                });
        }
    },
    complete: function (jqXHR, statusText) { // layui的table组件内部设置success和error方法，因此会造成在此设置error方法失效
        // console.log(jqXHR);
        if (jqXHR.status >= 200 && jqXHR.status < 300) {
            return;
        }
        switch (jqXHR.status) {
            case (500):
                layer.alert('服务器系统内部错误', {
                    icon: 2
                });
                break;
            case (401):
                layer.msg('您暂未登录或已掉线，请重新登录', {
                    icon: 2,
                    time: 1000,
                }, function (index) {
                    window.location = '/admin/page/login.html';
                });
                break;
            case (403):
                layer.alert('无权限执行此操作', {
                    icon: 2
                });
                break;
            case (408):
                layer.alert('请求超时', {
                    icon: 2
                });
                break;
            default:
                break;
        }
    }
});