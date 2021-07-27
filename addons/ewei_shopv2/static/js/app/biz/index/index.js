define(['core', 'tpl', 'swipers'], function (core, tpl, swipers) {
    var modal = {
        params: {},
        submit_message: false,
        is_draw: true
    };
    modal.init = function (param) {
        modal.params = param;
        for (var i = 1; i <= 7; i++) {
            $('.page_' + i).hide();
        }
        $('.page_1').show();

        modal.page_1();

        // modal.page_4();
    };
    modal.page_1 = function () {
        // beijingyonglian=document.getElementById("beijingyonglian");
        $('.beijingyonglian').attr('src', 'http://ythd2.uwechat.com.cn/page/qiaozhongbeijin.mp3');
        $('.beijingyonglian')[0].play();
        //  beijingyonglian.play()

        setTimeout(function () {
            $page_2 = '\t<div class="fangdatu">\n' +
                '\t\t\t\t<div class="zuibei"></div>\n' +
                '\t\t\t\t<div class="zuibei1 "></div>\n' +
                '\t\t\t\t<div class="zuibei2 ">\n' +
                '\t\t\t\t\t<div class="zuibei4 "></div>\n' +
                '\t\t\t\t</div>\n' +
                '\n' +
                '\t\t\t</div>';
            // $('.page_2').append($page_2);
        }, 200)
        timeout = 3000
        var ss = 0;
        var page1_sw = new swipers('.page_1 .swiper-container', {
            autoplay: {
                delay: timeout,
            },
            loop: true,
            on: {
                slideChangeTransitionEnd: function () {
                    console.log(this.activeIndex);
                    eq = this.activeIndex;
                    $('.fui-swipe-bullet ').eq(eq).click();
                    if (this.activeIndex == 3) {

                        setTimeout(function () {
                            if (ss == 0) {
                                console.log(2, ss);
                                modal.page_2();
                                $('.page_1').hide();
                                $('.page_2').show();
                                ss = 1;
                            } else {

                            }

                        }, timeout);
                    }


                },
                touchEnd: function (event) {


                    TR = this.translate;
                    console.log(TR)
                    var val = $('body').width() * 2.5;
                    console.log(val)
                    if (TR < -val) {
                        this.setTranslate(TR);
                        if (ss == 0) {
                            ss = 1
                            modal.page_2();
                            $('.page_1').hide();
                            $('.page_2').show();
                        } else {

                        }
                    }
                },
            },
        });

        $('.page_1 .tup').unbind('click').click(function () {
            page1_sw.slideNext();
        })

    }
    modal.page_2 = function () {
        $page_3 = '';


        setTimeout(function () {
            //        $('.page_2 .fangdatu ').css('opacity','0');
            $('.page_2 .fangdatu').addClass('a');
        }, 200);

        de = 1;
        var settime = setInterval(function () {
            de += 0.002;
            $('.page_2 .fangdatu').css('transform', 'scale(' + de + ')');
            if (de >= 2) {
                clearInterval(settime);
                $('.page_2').css('opacity', '0');
                $('.page_2').hide();
                $('.page_3').show();
                modal.page_3();
            }
            if (de >= 1.5) {
                //console.log($page_3)
                if (!$page_3) {
                    $page_3 = '\t<div class="fangdatu">\n' +
                        '\t\t\t<div class="yundong"></div>\n' +
                        '\t\t\t<div class="yundong1"></div>\n' +
                        '\t\t\t<div class="yundong3"></div>\n' +
                        '\t\t\t<div class="wukgc">\n' +
                        '\t\t\t\t<img src="https://uwechat-1251292385.cos.ap-shanghai.myqcloud.com/huodog/page/3.18.png" class="wz_318">\n' +
                        '\t\t\t\t<div class="zhong">\n' +
                        '\n' +
                        '\t\t\t\t\t<img src="https://uwechat-1251292385.cos.ap-shanghai.myqcloud.com/huodog/page/2.png" class="zhong_img ">\n' +
                        '\t\t\t\t\t<div class="container" >\n' +
                        '\n' +
                        '\t\t\t\t\t</div>\n' +
                        '\n' +
                        '\t\t\t\t</div>\n' +
                        '\t\t\t\t<div class="jinruzhuye">进入主页</div>\n' +
                        '\t\t\t</div>\n' +
                        '\t\t\t\n' +
                        '\t\t</div>\n' +
                        '\t\t<audio src=""  class="yingyue" autostart="false" loop="false" type="audio/mpeg">\n';
                    // $('.page_3').append($page_3);
                }
            }
        }, 10)
    }

    modal.page_3 = function () {
        $('.page_2 .fangdatu').removeClass('a');

        ifes = 0;

        var settime_3 = setInterval(function () {

            fang();
            ifes += 1;
            if (ifes == 17) {
                clearInterval(settime_3);
                $('.page_3').hide();
                $('.page_4').show();
                modal.page_4();
                $('.beijingyonglian').remove()
            }

        }, 4000);
        fang = function () {
            $('.yingyue').attr('src', 'http://ythd2.uwechat.com.cn/page/qiaozhong.mp3');
            $('.yingyue')[0].play();

            $htetml = $('\t<div class="water water1"></div>\n' +
                '\t\t\t\t\t\t<div class="water water2"></div>\n' +
                '\t\t\t\t\t\t<div class="water water3"></div>\n' +
                '\t\t\t\t\t\t<div class="water water4"></div>\n' +
                '\t\t\t\t\t\t<div class="water water5"></div>\n' +
                '\t\t\t\t\t\t<div class="water water6"></div>\n' +
                '\t\t\t\t ');
            setTimeout(function () {
                $('.page_3 .container').append($htetml);
                $('.page_3 .zhong').addClass('dongqi');

            }, 200)
            setTimeout(function () {
                $htetml.remove();
            }, 3000)


            setTimeout(function () {
                // $('.page_3 .zhong').removeClass('dongqi');
            }, 3900)


            setTimeout(function () {
                $('.yingyue').attr('src', '');
            }, 2500)
        }
        fang();
        $('.page_3 .jinruzhuye').click(function () {
            $('.page_3').hide();
            $('.page_4').show();
            modal.page_4();
            $('.beijingyonglian').remove()
            clearInterval(settime_3);
        })

    }

    //首页
    modal.page_4 = function () {

        nav_animation();
        subjList();

        //题目
        function subjList() {
            var html = '';
            var list = modal.params.subjList;
            for (var i in list) {
                var index = parseInt(Number(i) + 1);
                var name = 'model[' + index + '][answer]';
                var name_id = 'model[' + index + '][id]';
                html += ' <div class="swiper-slide ">\n' +
                    '                                    <div class="subj">\n' +
                    '                                        <div class="title">' + index + '.' + list[i].title + '</div>\n' +
                    '                                        <div class="answer">\n' +
                    '                                       <input type="text" value="' + list[i].id + '" name="' + name_id + '" hidden>' +
                    '                                            <div class="answer-item"><input class="radio_type" value="A" type="radio" id="sub' + index + 'A" name="' + name + '"> <label' +
                    '                                                        for="sub' + index + 'A">A.' + list[i].answer_a + '</label></div>\n' +
                    '                                            <div class="answer-item"><input class="radio_type" value="B" type="radio" id="sub' + index + 'B" name="' + name + '"> <label' +
                    '                                                        for="sub' + index + 'B"> B.' + list[i].answer_b + '</label></div>\n' +
                    '                                            <div class="answer-item"><input class="radio_type"  value="C" type="radio" id="sub' + index + 'C" name="' + name + '"> <label' +
                    '                                                        for="sub' + index + 'C"> C.' + list[i].answer_c + '</label></div>\n' +
                    '                                            <div class="answer-item"><input class="radio_type"  value="D" type="radio" id="sub' + index + 'D" name="' + name + '"> <label' +
                    '                                                        for="sub' + index + 'D"> D.' + list[i].answer_d + '</label></div>\n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '                                </div>'
            }
            $('.page_10 .swiper-wrapper').html(html);

            //答案渲染
            var answer = "<span style='color: red'>答案:</span> " + modal.params.subjList[0].tips;
            $('.page_10 .tips').html(answer);

            var process_text = '1/' + modal.params.subjList.length;
            $('.process_text').html(process_text);
        }

        //在线敲钟
        $('#page_4 .cyaobaidezhgo').unbind('click').on('click', function () {

            $('#content4').addClass('a');
            $('#nav').addClass('a');
            $('.top').addClass('a');
            $('.zaixianrenshu').addClass('a');

            setTimeout(function () {
                $('#content4').removeClass('a');
                $('#nav').removeClass('a');
                $('.top').removeClass('a');
                $('.zaixianrenshu').removeClass('a');

                /* 图层操作*/
                $('#page_4').hide();

                $('.page_15').css('opacity', 1);
                $('.page_15').show();
                modal.page_15();

            }, 1200)
        })

        // 前言
        $('#nav-item1').unbind('click').on('click', function () {
            $('#content4').addClass('a');
            $('#nav').addClass('a');
            $('.top').addClass('a');
            $('.zaixianrenshu').addClass('a');


            setTimeout(function () {
                $('#content4').removeClass('a');
                $('#nav').removeClass('a');
                $('.top').removeClass('a');
                $('.zaixianrenshu').removeClass('a');

                /* 图层操作*/
                $('#page_4').hide();

                $('.page_13').show();
                modal.page_13();

            }, 1200)

        })

        // 奏唱国歌
        $('#nav-item2').unbind('click').on('click', function () {
            $('#content4').addClass('a');
            $('#nav').addClass('a');
            $('.top').addClass('a');
            $('.zaixianrenshu').addClass('a');


            setTimeout(function () {
                $('#content4').removeClass('a');
                $('#nav').removeClass('a');
                $('.top').removeClass('a');
                $('.zaixianrenshu').removeClass('a');

                /* 图层操作*/
                $('#page_4').hide();

                $('.page_6').show();
                modal.page_6();

            }, 1200)

        })

        // 往昔回顾
        $('#nav-item3').unbind('click').on('click', function () {
            $('#content4').addClass('a');
            $('#nav').addClass('a');
            $('.top').addClass('a');
            $('.zaixianrenshu').addClass('a');


            setTimeout(function () {
                $('#content4').removeClass('a');
                $('#nav').removeClass('a');
                $('.top').removeClass('a');
                $('.zaixianrenshu').removeClass('a');


                /* 图层操作*/
                $('#page_4').hide();

                $('.page_7').show();
                modal.page_7();

            }, 1200)

        })


        // 主题歌曲
        $('#nav-item4').unbind('click').on('click', function () {
            $('#content4').addClass('a');
            $('#nav').addClass('a');
            $('.top').addClass('a');
            $('.zaixianrenshu').addClass('a');


            setTimeout(function () {
                $('#content4').removeClass('a');
                $('#nav').removeClass('a');
                $('.top').removeClass('a');
                $('.zaixianrenshu').removeClass('a');

                /* 图层操作*/
                $('#page_4').hide();

                $('.page_8').show();
                modal.page_8();

            }, 1200)

        })

        // 钟铭诵读
        $('#nav-item5').unbind('click').on('click', function () {
            $('#content4').addClass('a');
            $('#nav').addClass('a');
            $('.top').addClass('a');
            $('.zaixianrenshu').addClass('a');


            setTimeout(function () {
                $('#content4').removeClass('a');
                $('#nav').removeClass('a');
                $('.top').removeClass('a');
                $('.zaixianrenshu').removeClass('a');

                /* 图层操作*/
                $('#page_4').hide();

                $('.page_9').show();
                modal.page_9();

            }, 1200)

        })

        // 线上教育
        $('#nav-item6').unbind('click').on('click', function () {
            $('#content4').addClass('a');
            $('#nav').addClass('a');
            $('.top').addClass('a');
            $('.zaixianrenshu').addClass('a');

            setTimeout(function () {
                $('#content4').removeClass('a');
                $('#nav').removeClass('a');
                $('.top').removeClass('a');
                $('.zaixianrenshu').removeClass('a');

                /* 图层操作*/
                $('#page_4').hide();

                $('.page_12').show();
                modal.page_12();

            }, 1200)

        })


        // 有奖问答
        $('#nav-item7').unbind('click').on('click', function () {
            $('#content4').addClass('a');
            $('#nav').addClass('a');
            $('.top').addClass('a');
            $('.zaixianrenshu').addClass('a');

            setTimeout(function () {
                $('#content4').removeClass('a');
                $('#nav').removeClass('a');
                $('.top').removeClass('a');
                $('.zaixianrenshu').removeClass('a');

                /* 图层操作*/
                $('#page_4').hide();

                $('.page_10').show();
                modal.page_10();

            }, 1200)

        })

        // 留下感言
        $('#nav-item8').unbind('click').on('click', function () {
            $('#content4').addClass('a');
            $('#nav').addClass('a');
            $('.top').addClass('a');
            $('.zaixianrenshu').addClass('a');

            setTimeout(function () {
                $('#content4').removeClass('a');
                $('#nav').removeClass('a');
                $('.top').removeClass('a');
                $('.zaixianrenshu').removeClass('a');

                /* 图层操作*/
                $('#page_4').hide();

                $('.page_11').show();
                modal.page_11();

            }, 1200)


        })

        //进入博物馆
        $('#nav-item9').unbind('click').on('click', function () {
            window.location.href = 'http://dwxsv.okaygis.com/szzyj/pano/sky/index.html';


        })


        function nav_animation() {
            var length = $('.nav-item').length;

            for (var i = 1; i <= length; i++) {
                var second = parseFloat(0.5 + i * 0.1).toFixed(2);
                $('#nav-item' + i).css("animation", "page_4_nav_item_position " + second + "s ease-in forwards");

            }
        }


    }
    modal.page_5 = function () {
        $('.page_5 .goindex').unbind('click').on('click', function () {
            $('.shiping').trigger('pause');

            $('.page_5').hide();
            $('.page_4').show();
            modal.page_4();

        })
    }

    modal.page_6 = function () {
        var music = document.getElementById("music");
        var src = $('#music').attr('src', 'http://ythd2.uwechat.com.cn/page/guoge.mp3');
        bofang()
        /* $.each($('.page_6 .leader_text'), function (index, item) {
             $(item).removeClass('item');
             if (index > 0) {
                 if (!($(item).hasClass('item'))) {
                     $(item).addClass('item');

                 }
             }

         });
         $('.bofang').show();
         $('.zanting').hide();
         $('.cipan').css('animation-play-state', 'paused');*/

        //切换歌曲
        /*  $('.page_6 .leader_text ').unbind('click').on('click', function () {
              music.pause();
              var index = $(this).data('index');
              switch (index) {
                  case 1:
                      $('#music').attr('src', 'https://uwechat-1251292385.cos.ap-shanghai.myqcloud.com/huodog/page/guoge.mp3');
                      break;
                  case 2:
                      $('#music').attr('src', 'https://uwechat-1251292385.cos.ap-shanghai.myqcloud.com/huodog/page/shaoxiandui.mp3');
                      break;
                  case 3:
                      $('#music').attr('src', 'https://uwechat-1251292385.cos.ap-shanghai.myqcloud.com/huodog/page/buwangchuxin.mp3');
                      break;
                  case 4:
                      $('#music').attr('src', 'https://uwechat-1251292385.cos.ap-shanghai.myqcloud.com/huodog/page/zhonghuaminzu.mp3');
                      break;
                  case 5:
                      $('#music').attr('src', 'https://uwechat-1251292385.cos.ap-shanghai.myqcloud.com/huodog/page/zouxiangfuxing.mp3');
                      break;
              }
              $.each($('.page_6 .leader_text'), function (index, item) {
                  $(item).addClass('item');
              });
              $(this).removeClass('item');
              if ($('.cipan').hasClass('rotate')) {
                  var status = $('.cipan').css('animation-play-state');
                  if (status == 'running') {

                  } else {
                      // 播放
                      $('.bofang').hide();
                      $('.zanting').show();
                      $('.cipan').css('animation-play-state', 'running');
                  }

              } else {
                  // 播放
                  $('.bofang').hide();
                  $('.zanting').show();


                  $('.cipan').addClass('rotate');
                  $('.cipan').css('animation-play-state', 'running');

              }
              music.play();


          });*/

        $('.cipan').unbind('click').on('click', function () {

            bofang()
        });

        $('.page_6 .aa').unbind('click').on('click', function () {
            bofang()
        })


        $('.page_6 .goindex').unbind('click').on('click', function () {
            $('.page_6').hide();
            //暂停播放
            music.pause();
            if ($('.page_6 .cipan').css('animation-play-state') == 'running') {
                $('.page_6 .cipan').css('animation-play-state', 'paused');
            }


            $('.page_4').show();
            modal.page_4();


        })

        function bofang() {
            var music = document.getElementById("music");
            if ($('.page_6 .cipan').hasClass('rotate')) {
                var status = $('.cipan').css('animation-play-state');
                if (status == 'running') {
                    // 暂停
                    $('.page_6 .bofang').show();
                    $('.page_6 .zanting').hide();

                    $('.page_6 .cipan').css('animation-play-state', 'paused');
                    music.pause();
                } else {
                    // 播放
                    $('.page_6 .bofang').hide();
                    $('.page_6 .zanting').show();
                    $('.page_6 .cipan').css('animation-play-state', 'running');
                    music.play();
                }

            } else {
                // 播放
                $('.page_6 .bofang').hide();
                $('.page_6 .zanting').show();

                music.play();

                $('.page_6 .cipan').addClass('rotate');
                $('.page_6 .cipan').css('animation-play-state', 'running');

            }
        }

        music.addEventListener('ended', function () {
            $('.page_6 .bofang').show();
            $('.page_6 .zanting').hide();

        }, false);
    }

    modal.page_7 = function () {


        $('.page_7 .vedio').unbind('click').on('click', function () {
            var huodongzhuanti = document.getElementById('huodongzhuanti');
            var is_play = $('.page_7 .aa').css('display');
            console.log(is_play)
            if (is_play == 'block') {
                huodongzhuanti.play();
                $('.page_7 .aa').css('display', 'none');
            } else {
                $('.page_7 .aa').css('display', 'block');
                huodongzhuanti.pause();
            }
            // $('.page_8 vedio')[0].play();
        })

        $('.page_7 .goindex').unbind('click').on('click', function () {
            $('.shiping').trigger('pause');
            $('.page_7 .aa').css('display', 'block');


            $('.page_7').hide();
            $('.page_4').show();
            modal.page_4();

        })


        var swiper = new swipers('.page_7 .swiper-container', {
            watchSlidesProgress: true,
            slidesPerView: 'auto',
            centeredSlides: true,
            loop: true,
            loopedSlides: 3,
            autoplay: true,
            on: {
                progress: function (progress) {
                    for (i = 0; i < this.slides.length; i++) {
                        var slide = this.slides.eq(i);
                        var slideProgress = this.slides[i].progress;
                        modify = 1;
                        if (Math.abs(slideProgress) > 1) {
                            modify = (Math.abs(slideProgress) - 1) * 0.3 + 1;
                        }
                        translate = slideProgress * modify * 260 + 'px';
                        scale = 1 - Math.abs(slideProgress) / 5;
                        zIndex = 999 - Math.abs(Math.round(10 * slideProgress));
                        slide.transform('translateX(' + translate + ') scale(' + scale + ')');
                        slide.css('zIndex', zIndex);
                        slide.css('opacity', 1);
                        if (Math.abs(slideProgress) > 3) {
                            slide.css('opacity', 0);
                        }
                    }
                },
                setTransition: function (transition) {
                    for (var i = 0; i < this.slides.length; i++) {
                        var slide = this.slides.eq(i)
                        slide.transition(transition);
                    }

                }

            },
            navigation: {
                nextEl: '.xiangzuo',
                prevEl: '.xiangyou',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    }

    modal.page_8 = function () {

        $('.page_8 .vedio').unbind('click').on('click', function () {
            var zhutiqu = document.getElementById('zhutiqu');
            var is_play = $('.page_8 .aa').css('display');
            console.log(is_play)
            if (is_play == 'block') {
                zhutiqu.play();
                $('.page_8 .aa').css('display', 'none');
            } else {
                $('.page_8 .aa').css('display', 'block');
                zhutiqu.pause();
            }
            // $('.page_8 vedio')[0].play();
        })

        $('.page_8 .goindex').unbind('click').on('click', function () {
            $('.shiping').trigger('pause');
            $('.page_8 .aa').css('display', 'block');


            $('.page_8').hide();
            $('.page_4').show();
            modal.page_4();

        })
    }

    //钟鸣朗诵
    modal.page_9 = function () {

        $('.page_9 .vedio').unbind('click').on('click', function () {
            var zhongminglangsong = document.getElementById('zhongminglangsong');
            var is_play = $('.page_9 .aa').css('display');
            console.log(is_play)
            if (is_play == 'block') {
                zhongminglangsong.play();
                $('.page_9 .aa').css('display', 'none');
            } else {
                $('.page_9 .aa').css('display', 'block');
                zhongminglangsong.pause();
            }
            // $('.page_8 vedio')[0].play();
        })

        $('.page_9 .goindex').unbind('click').on('click', function () {
            $('.shiping').trigger('pause');
            $('.page_9 .aa').css('display', 'block');


            $('.page_9').hide();
            $('.page_4').show();
            modal.page_4();

        })
    }

    //抽奖
    modal.page_10 = function () {
        $('.page_10 .finish_box').show();
        subjList();

        //题目
        function subjList() {
            var html = '';
            var list = modal.params.subjList;
            for (var i in list) {
                var index = parseInt(Number(i) + 1);
                var name = 'model[' + index + '][answer]';
                var name_id = 'model[' + index + '][id]';
                html += ' <div class="swiper-slide ">\n' +
                    '                                    <div class="subj">\n' +
                    '                                        <div class="title">' + index + '.' + list[i].title + '</div>\n' +
                    '                                        <div class="answer">\n' +
                    '                                       <input type="text" value="' + list[i].id + '" name="' + name_id + '" hidden>' +
                    '                                            <div class="answer-item"><input class="radio_type" value="A" type="radio" id="sub' + index + 'A" name="' + name + '"> <label' +
                    '                                                        for="sub' + index + 'A">A.' + list[i].answer_a + '</label></div>\n' +
                    '                                            <div class="answer-item"><input class="radio_type" value="B" type="radio" id="sub' + index + 'B" name="' + name + '"> <label' +
                    '                                                        for="sub' + index + 'B"> B.' + list[i].answer_b + '</label></div>\n' +
                    '                                            <div class="answer-item"><input class="radio_type"  value="C" type="radio" id="sub' + index + 'C" name="' + name + '"> <label' +
                    '                                                        for="sub' + index + 'C"> C.' + list[i].answer_c + '</label></div>\n' +
                    '                                            <div class="answer-item"><input class="radio_type"  value="D" type="radio" id="sub' + index + 'D" name="' + name + '"> <label' +
                    '                                                        for="sub' + index + 'D"> D.' + list[i].answer_d + '</label></div>\n' +
                    '                                        </div>\n' +
                    '                                    </div>\n' +
                    '                                </div>'
            }
            $('.page_10 .swiper-wrapper').html(html);

            //答案渲染
            var answer = "<span style='color: red'>答案:</span> " + modal.params.subjList[0].tips;
            $('.page_10 .tips').html(answer);

            var process_text = '1/' + modal.params.subjList.length;
            $('.process_text').html(process_text);
        }
        var index_did = 0;
        var swp = new swipers('.page_10 .swiper-container', {
            allowTouchMove: false,
            on: {
                reachEnd: function () {
                    $('#btn2').hide();
                    $('.submit').show();
                },
                slideChange: function () {
                    index_did = this.activeIndex;
                    var answer = ' <span style="color:red">答案: </span>' + modal.params.subjList[index_did].tips;
                    var process_text = Number(index_did + 1) + '/' + modal.params.subjList.length;
                    $('.process_text').html(process_text);
                    $('.page_10 .tips').html(answer);
                    $('.page_10 .tips_box').hide()
                },
            },
        });
        console.log(index_did);
        console.log(swp.activeIndex);


        //下一题
        $('#btn2').unbind('click').on('click', function () {
            var list = modal.params.subjList;

            //判断答案是否正确
            console.log(swp.activeIndex);
            console.log(index_did);
            var index = index_did;
            //题目答案
            var answer = list[index].answer;
            var selectAnswer = $(swp.$el.find('.swiper-slide')[index]).find('input:radio:checked').val();
            console.log(answer, selectAnswer)
            if (answer == selectAnswer) {
                swp.slideNext();
            } else {
                FoxUI.alert('本题答错啦，请再想想吧!');
            }

        })


        $('.page_10 .submit').unbind('click').on('click', function () {
            var list = modal.params.subjList;
            //判断答案是否正确
            console.log(swp.activeIndex);
            var index = swp.activeIndex;
            //题目答案
            var answer = list[index].answer;
            var selectAnswer = $(swp.$el.find('.swiper-slide')[index]).find('input:radio:checked').val();
            if (answer != selectAnswer) {
                FoxUI.alert('本题答错啦，请再想想吧!');
                return;
            }


            $('.page_10 .content1').hide();
            $('.page_10 .content2').show();

        })

        var is_draw_false_start = false;
        //开始抽奖
        $('.page_10 .draw_start_btn').unbind('click').on('click', function () {

          /*  var is_draw = modal.is_draw;
            if (is_draw) {
                $('.page_10 .draw').css('transform', '');
                $('.page_10 .draw').css('transition-duration', '0s');
                $('.page_10 .draw').css('transform', 'rotate(0deg)');
                modal.is_draw = false;

                //抽奖
                var d = {}
                var t = $('#subject').serializeArray();
                $.each(t, function () {
                    d[this.name] = this.value;
                });
                d['yz']= modal.params.yz;
                d['time']= modal.params.time;
                core.json('index/index/lottery', d, function (ret) {
                    if (ret.status == 1) {

                        var type = ret.result.type;
                        var deg = 160;
                        var img_src = '';
                        var msg = ret.result.msg;
                        /!*switch (type) {
                            case 1: //1等奖
                                deg = 10;
                                img_src = 'https://uwechat-1251292385.cos.ap-shanghai.myqcloud.com/huodog/page/1dengjiang.png';
                                modal.is_draw = false;

                                break;
                            case 2: // 2等奖
                                deg = 300;
                                img_src = 'https://uwechat-1251292385.cos.ap-shanghai.myqcloud.com/huodog/page/2dengjiang.png';
                                modal.is_draw = false;
                                break;
                            case 3: //3等奖
                                deg = 110;
                                img_src = 'https://uwechat-1251292385.cos.ap-shanghai.myqcloud.com/huodog/page/3dengjiang.png';
                                modal.is_draw = false;

                                break;
                            case 4: //特别奖
                                deg = 340;
                                modal.is_draw = false;

                                break;
                            case 5: //谢谢参与
                                deg = 160;
                                modal.is_draw = true;
                                console.log(111)
                                break;
                            case 6: //谢谢参与
                                deg = 160;
                                modal.is_draw = true;

                                break;
                        }*!/

                        if (type == 1) {
                            deg = 10;
                            img_src = 'https://uwechat-1251292385.cos.ap-shanghai.myqcloud.com/huodog/page/1dengjiang.png';
                            modal.is_draw = false;
                        }
                        if (type == 2) {
                            deg = 300;
                            img_src = 'https://uwechat-1251292385.cos.ap-shanghai.myqcloud.com/huodog/page/2dengjiang.png';
                            modal.is_draw = false;
                        }
                        if (type == 3) {
                            deg = 110;
                            img_src = 'https://uwechat-1251292385.cos.ap-shanghai.myqcloud.com/huodog/page/3dengjiang.png';
                            modal.is_draw = false;
                        }
                        if (type == 4) {
                            deg = 340;
                            modal.is_draw = false;
                        }
                        if (type == 5) {
                            deg = 160;
                            modal.is_draw = true;
                        }
                        if (type == 6) {
                            deg = 160;
                            modal.is_draw = true;
                        }


                        var rotate = Number(1800 * 10 + deg);

                        //抽奖
                        $('.page_10 .draw').css('transform', 'rotate(' + rotate + 'deg)');
                        $('.page_10 .draw').css('transition-duration', '4s');

                        setTimeout(function () {
                            modal.is_draw = true;

                            is_draw_false_start = true;

                            if (type == 4 && ret.result.code == 1) {
                                $('.page_10 .address_info').css('display', 'block');
                            }

                            var arr = [1, 2, 3];
                            if (arr.includes(type)) {
                                $('.page_10 .award_img').attr('src', img_src);
                                $('.page_10 .award_box').css('display', 'block');
                            }
                            else {
                                if (type != 4) {
                                  /!*  $('.page_10 .content1').show();
                                    $('.page_10 .content2').hide();
                                    // $('.page_10 .award_box').hide();
                                    $('.page_10').hide();
                                    $('.page_4').show();
                                    swp.destroy();
                                    modal.page_4();*!/
                                }

                                FoxUI.alert(msg);

                            }
                            // FoxUI.toast.show(msg);


                        }, 4900)


                    } else {

                        modal.is_draw = true;
                        FoxUI.toast.show(ret.result.message);
                    }
                }, true, true);


            }else {

               /!* if (is_draw_false_start) {
                    is_draw_false_start = false;
                    $('.page_10 .draw').css('transform', '');
                    $('.page_10 .draw').css('transition-duration', '0s');
                    $('.page_10 .draw').css('transform', 'rotate(0deg)');
                    setTimeout(function () {
                        //抽奖
                        $('.page_10 .draw').css('transform', 'rotate(18160deg)');
                        $('.page_10 .draw').css('transition-duration', '4s');
                    },100)

                    setTimeout(function () {
                        /!*   $('.page_10 .content1').show();
                           $('.page_10 .content2').hide();
                           // $('.page_10 .award_box').hide();
                           $('.page_10').hide();
                           $('.page_4').show();
                           swp.destroy();
                           modal.page_4();*!/
                        is_draw_false_start = true;

                        FoxUI.alert('谢谢参与');
                    },4900)
                }*!/




            }*/

        })

        $('.page_10 .finish_box').unbind('click').on('click', function () {
            $(this).hide();
        });

        //提交地址
        $('.page_10 .address_info .btn').unbind('click').on('click', function () {
            /*var d = {};
            var t = $('#address').serializeArray();
            $.each(t, function () {
                d[this.name] = this.value;
            });

            core.json('index/index/address', d, function (ret) {
                if (ret.status == 1) {
                    // FoxUI.alert('提交成功');
                    FoxUI.toast.show('提交成功');

                    $('.page_10 input[name="realname"]').val('');
                    $('.page_10 input[name="mobile"]').val('');
                    $('.page_10 input[name="city"]').val('');
                    $('.page_10 input[name="address"]').val('');
                    $('.page_10 .address_info').css('display', 'none');

                  /!*  swp.destroy();
                    $('.page_10 .content1').show();
                    $('.page_10 .content2').hide();
                    // $('.page_10 .award_box').hide();
                    $('.page_10').hide();
                    $('.page_4').show();
                    modal.page_4();*!/

                } else {
                    FoxUI.toast.show('提交失败,稍后在试试吧');
                }

            }, true, true);*/
        })

        $('.page_10 .award_box').unbind('click').on('click',function () {
            $(this).hide();
           /* swp.destroy();
            $('.page_10 .content1').show();
            $('.page_10 .content2').hide();
            // $('.page_10 .award_box').hide();
            $('.page_10').hide();
            $('.page_4').show();
            modal.page_4();*/
        })

        //灯泡
        $('.page_10 .dengpao_div').unbind('click').on('click', function () {
            $('.page_10 .tips_box').toggle();
        })


        //说明
        $('.page_10 .draw_btn').unbind('click').on('click', function () {
            $('.page_10 .draw_bubble').toggle();
        })

        $('.page_10 .goindex').unbind('click').on('click', function () {
            $('.page_10').hide();
            $('.page_4').show();
            swp.destroy();
            modal.page_4();

        })

    }

    modal.page_11 = function () {
        var list = modal.params.msglist;
        console.log(list)
        var html = '';
        for (var i = 0; i < list.length; i++) {
            html +=
                '<div class="board">' +
                '      <div class="message">' + list[i].message + '</div>' +
                '          <div class="info">' + list[i].name + '</div>' +
                '</div>';
        }

        $('.page_11 .board_content').html(html);


        //提交留言
        $('.page_11 .textarea_btn').unbind('click').on('click', function () {
            var message = $('#message').val();
            var submit_message = modal.params.submit_message;

            if (!submit_message && message) {
                modal.params.submit_message = true;
                core.json('index/index/addmessage', {message: message}, function (ret) {
                    var result = ret.result;
                    modal.params.submit_message = false;
                    FoxUI.alert('留言成功!');
                    $('#message').val('');

                }, true, true);
            }
        })

        //向上滑动
        $('.page_11 .xiangshang').unbind('click').on('click', function () {
            newTop = $('.page_11 .board_content').scrollTop();
            newTop = newTop - 40;
            $('.page_11 .board_content').scrollTop(newTop);
            console.log(newTop)


        })

        //向上滑动
        $('.page_11 .xiangxia').unbind('click').on('click', function () {
            newTop = $('.page_11 .board_content').scrollTop();
            $('.page_11 .board_content').scrollTop(newTop + 40);
            console.log(newTop)


        })

        $('.page_11 .goindex').unbind('click').on('click', function () {
            $('.page_11').hide();
            $('.page_4').show();
            modal.page_4();

        })
    }

    modal.page_12 = function () {


        $('.page_12 .vedio').unbind('click').on('click', function () {
            var zaixianketang = document.getElementById('zaixianketang');
            var is_play = $('.page_12 .aa').css('display');
            console.log(is_play)
            if (is_play == 'block') {
                zaixianketang.play();
                $('.page_12 .aa').css('display', 'none');
            } else {
                $('.page_12 .aa').css('display', 'block');
                zaixianketang.pause();
            }
            // $('.page_8 vedio')[0].play();
        })


        $('.page_12 .goindex').unbind('click').on('click', function () {
            $('.shiping').trigger('pause');
            $('.page_12 .aa').css('display', 'block');


            $('.page_12').hide();
            $('.page_4').show();
            modal.page_4();

        })
    }

    modal.page_13 = function () {
        $('#qianyan_music').attr('src', 'https://uwechat-1251292385.cos.ap-shanghai.myqcloud.com/huodog/page/qianyan_music.wav');
        var qianyan_music = document.getElementById("qianyan_music");
        qianyan_music.play();

        var newTop;
        //使用定时器
        var timer = setInterval(function () {
            //文本是否已经到底部（底部出现在浏览器窗口中1）


            //每次在原来的基础上移动
            newTop = $('.page_13 .text_container').scrollTop();
            $('.page_13 .text_container').scrollTop(newTop + 5);

        }, 1000);


        $('.page_13 .goindex').unbind('click').on('click', function () {
            $('.page_13').hide();
            $('.page_4').show();
            modal.page_4();
            qianyan_music.pause();
            $('#qianyan_music').attr('src', '')

        })

        $('.page_13 .qianyan_music_icon').unbind('click').on('click', function () {
            if ($('.page_13 .qianyan_music_icon span').hasClass('icon-shengyinbofang')) {
                //在播放中,进行暂停
                qianyan_music.pause();
                $('.page_13 .qianyan_music_icon span').removeClass('icon-shengyinbofang')
                $('.page_13 .qianyan_music_icon span').addClass('icon-shengyinzanting');
            } else {
                qianyan_music.play();
                $('.page_13 .qianyan_music_icon span').addClass('icon-shengyinbofang')
                $('.page_13 .qianyan_music_icon span').removeClass('icon-shengyinzanting');
            }
        })
    }

    modal.page_14 = function () {
        $page_3 = '';
        $('.page_14 .jinruzhuye').hide();
        setTimeout(function () {
            //        $('.page_2 .fangdatu ').css('opacity','0');
            $('.page_14 .fangdatu').addClass('a');
        }, 200);

        de = 1;
        var settime = setInterval(function () {
            de += 0.002;
            $('.page_14 .fangdatu').css('transform', 'scale(' + de + ')');
            if (de >= 1.5) {
                clearInterval(settime);
                $('.page_14 .jinruzhuye').show();
                // $('.page_14').css('opacity', '0');
                // $('.page_14').hide();
                //
                //       modal.page_3();
            }

        }, 10)

        $('.page_14 .jinruzhuye').click(function () {
            $('.page_14').css('opacity', '0');
            $('.page_14').hide();
            $('.page_4').show();
            modal.page_4();

        })

        var de = true;
        $('.page_14 .qiaozuoaxigaoo').click(function () {
            $('.page_14').css('opacity', '0');
            $('.page_14').hide();
            $('.page_3').show();
            modal.page_3();
            /*console.log(111)
             if (de) {
                 de = false;
                 $('.page_14 .qiaozuoaxigaoo_music').attr('src', '\\addons\\ewei_shopv2\\template\\mobile\\default\\static\\images\\page/qiaozhong.mp3');
                 $('.page_14 .qiaozuoaxigaoo_music')[0].play();
                 $('.page_14 .zuibei4').addClass('bb');
                 setTimeout(function () {
                     de = true
                     $('.page_14 .zuibei4').removeClass('bb');

                 },3900)
             }*/


        });

    }

    modal.page_15 = function () {
        $page_16 = '';


        setTimeout(function () {
            //        $('.page_2 .fangdatu ').css('opacity','0');
            $('.page_15 .fangdatu').addClass('a');
        }, 200);

        de = 1;
        var settime = setInterval(function () {
            de += 0.006;
            $('.page_15 .fangdatu').css('transform', 'scale(' + de + ')');
            if (de >= 2) {
                clearInterval(settime);
                $('.page_15').css('opacity', '0');
                $('.page_15').hide();
                $('.page_16').show();
                modal.page_16();
            }
            if (de >= 1.5) {
                //console.log($page_3)
                if (!$page_16) {
                    $page_16 = '\t<div class="fangdatu">\n' +
                        '\t\t\t<div class="yundong"></div>\n' +
                        '\t\t\t<div class="yundong1"></div>\n' +
                        '\t\t\t<div class="yundong3"></div>\n' +
                        '\t\t\t<div class="wukgc">\n' +
                        '\t\t\t\t<img src="https://uwechat-1251292385.cos.ap-shanghai.myqcloud.com/huodog/page/3.18.png" class="wz_318">\n' +
                        '\t\t\t\t<div class="zhong">\n' +
                        '\n' +
                        '\t\t\t\t\t<img src="https://uwechat-1251292385.cos.ap-shanghai.myqcloud.com/huodog/page/2.png" class="zhong_img ">\n' +
                        '\t\t\t\t\t<div class="container" >\n' +
                        '\n' +
                        '\t\t\t\t\t</div>\n' +
                        '\n' +
                        '\t\t\t\t</div>\n' +
                        '\t\t\t\t<div class="jinruzhuye">进入主页</div>\n' +
                        '\t\t\t</div>\n' +
                        '\t\t\t\n' +
                        '\t\t</div>\n' +
                        '\t\t<audio src=""  class="yingyue" autostart="false" loop="false" type="audio/mpeg">\n';
                    // $('.page_3').append($page_3);
                }
            }
        }, 10)
    }

    modal.page_16 = function () {
        $('.page_16 .click').show();

        $('.page_15 .fangdatu').removeClass('a');

        ifes = 0;

        // var settime_3 = setInterval(function () {
        //
        //     fang();
        //     ifes += 1;
        //     if (ifes == 17) {
        //         clearInterval(settime_3);
        //         $('.page_15').hide();
        //         $('.page_16').show();
        //         modal.page_16();
        //         $('.beijingyonglian').remove()
        //     }
        //
        // }, 4000);
        fang = function () {
            $('.yingyue').attr('src', 'http://ythd2.uwechat.com.cn/page/qiaozhong.mp3');
            $('.yingyue')[0].play();

            $htetml = $('\t<div class="water water1"></div>\n' +
                '\t\t\t\t\t\t<div class="water water2"></div>\n' +
                '\t\t\t\t\t\t<div class="water water3"></div>\n' +
                '\t\t\t\t\t\t<div class="water water4"></div>\n' +
                '\t\t\t\t\t\t<div class="water water5"></div>\n' +
                '\t\t\t\t\t\t<div class="water water6"></div>\n' +
                '\t\t\t\t ');
            setTimeout(function () {
                $('.page_16 .container').html($htetml);
                $('.page_16 .zhong').addClass('dongqi1');
                // $('.page_16 .zhong').addClass('dongqi1');

            }, 200)
            setTimeout(function () {
                $htetml.remove();
            }, 3000)


            setTimeout(function () {
                // $('.page_3 .zhong').removeClass('dongqi');
            }, 3900)


            setTimeout(function () {
                $('.yingyue').attr('src', '');
            }, 2500)
        }
        // fang();
        $('.page_16 .jinruzhuye').click(function () {
            $('.page_16').hide();
            $('.page_4').show();
            modal.page_4();
            $('.beijingyonglian').remove()
            // clearInterval(settime_3);
        })

        var onclick = false
        $('.page_16 .zhong').unbind('click').click(function () {
            if (!onclick) {
                $('.page_16 .click').hide();
                onclick = true;
                fang();
                setTimeout(function () {
                    onclick = false;
                    $('.page_16 .zhong').removeClass('dongqi1');
                    // $('.page_16 .click').addClass('img');


                },4500)
            }
        })
    }


    return modal
});