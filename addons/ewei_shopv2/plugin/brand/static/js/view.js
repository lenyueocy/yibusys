define(['core', 'tpl'], function (core, tpl) {
    var modal = {page: 1, cate: 0, keywords: ''};
    modal.init = function (params) {
        modal.page = params.page;
        modal.cate = params.cate;
        modal.keywords = params.keywords;
        $('.fui-content').infinite({
            onLoading: function () {
                modal.getList()
            }
        });
        if (modal.page == 1) {
            $('#container').html('');
            modal.getList(modal.keywords)
        }
        ;
        $("#tab a").off("click").on("click", function () {
            $(this).addClass("active").siblings().removeClass("active");
            modal.status = $(this).attr("data-status");
            modal.changeTab(modal.status)
        })
    };
    modal.changeTab = function (status) {
        $('.fui-content').infinite('init');
        $('.content-empty').hide(), $('#container').html(''), $('.infinite-loading').show();
        modal.page = 1, modal.cate = status, modal.getList()
    };
    modal.getList = function (keyword) {
        $(".content-loading").show();
        core.json('live/view/get_view', {page: modal.page}, function (ret) {
            var result = ret.result;
            if (result.total <= 0) {
                $('.content-empty').show();
                $('.fui-content').infinite('stop')
            } else {
                $('.content-empty').hide();
                $('.fui-content').infinite('init');
                if (result.list.length <= 0 || result.list.length < result.pagesize) {
                    $('.fui-content').infinite('stop')
                }
            }
            modal.page++;
            core.tpl('#container', 'tpl_live_list', result, modal.page > 1);
            $(".content-loading").hide();
            $(".live-subscribe-default-a").off("click").on("click", function () {
                var _this = $(this);
                var roomid = _this.data("id");
                var subscribe = _this.attr("data-subscribe");
                FoxUI.confirm(subscribe > 0 ? '????????????????????????' : '????????????????????????', "??????", function () {
                    core.json('live/room/favorite', {'roomid': roomid}, function (ret) {
                        if (ret.status == 0) {
                            FoxUI.loader.show(ret.result.message, 'icon icon-cry');
                            setTimeout(function () {
                                FoxUI.loader.hide()
                            }, 1000);
                            return
                        }
                        if (ret.result.favorite == 0) {
                            _this.removeClass('disabled').text('????????????');
                            _this.attr("data-subscribe", "0");
                            FoxUI.loader.show('??????????????????', 'icon icon-check')
                        } else {
                            _this.addClass('disabled').text('????????????');
                            _this.attr("data-subscribe", "1");
                            FoxUI.loader.show('????????????', 'icon icon-check')
                        }
                        setTimeout(function () {
                            FoxUI.loader.hide()
                        }, 1000)
                    }, true, true)
                });
                return false
            })
        })
    };
    return modal
});