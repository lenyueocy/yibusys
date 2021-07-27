define(['core', 'tpl', 'swipers'], function (core, tpl, swipers) {
    var modal = {
        params: {}
    };
    modal.init = function () {
        for (var i = 1; i <= 7; i++) {
            $('.page_' + i).hide();
        }
        $('.page_7').show();

        modal.page_7();

        // modal.page_4();
    };
    modal.page_1 = function () {
        $page_1 = '<div class="page_1 ">\n' +
            '\n' +
            '        <div class="swiper-container">\n' +
            '            <div class="swiper-wrapper">\n' +
            '                <div class="swiper-slide">\n' +
            '                    <div class="tup1 tup"></div>\n' +
            '                </div>\n' +
            '                <div class="swiper-slide">\n' +
            '                    <div class="tup2 tup"></div>\n' +
            '                </div>\n' +
            '                <div class="swiper-slide">\n' +
            '                    <div class="tup3 tup"></div>\n' +
            '                </div>\n' +
            '\n' +
            '            </div>\n' +
            '\n' +
            '        </div>\n' +
            '\n' +
            '\n' +
            '    </div>';
        $('body').append($page_1);
        timeout = 3000
        window.onload = function () {
            modal.page_2();
        };
        new swipers('.page_1 .swiper-container', {
            autoplay: {
                delay: timeout,
            },
            pagination: {
                el: '.swiper-pagination',
            },
            on: {
                slideChangeTransitionEnd: function () {
                    console.log(this.activeIndex);
                    eq = this.activeIndex;
                    $('.fui-swipe-bullet ').eq(eq).click();
                    if (this.activeIndex == 2) {
                        setTimeout(function () {
                            $('.page_1').hide();
                            //modal.page_2();
                            $('.page_2').show();
                        }, timeout);
                    }
                },
            },
        });

    }
    modal.page_2 = function () {

        $page_2 = '\n' +
            '    <div class="page_2">\n' +
            '        <div class="fangdatu">\n' +
            '\n' +
            '        </div>\n' +
            '    </div>';
        $('body').append($page_2);


        setTimeout(function () {
            setTimeout(function () {
                $('.page_2 .fangdatu').addClass('a');
            }, 10);
            setTimeout(function () {
                $('.page_2 .fangdatu ').css('opacity', '0');
            }, 2000);
            setTimeout(function () {
                $('.page_2').css('opacity', '0');
                $('.page_2').hide();
                $('.page_3').show();
                modal.page_3();
            }, 4000);
        }, 50);
    }
    modal.page_3 = function () {
        $('.page_3 .zhong').click(function () {
            $htetml = $('\t<div class="water water1"></div>\n' +
                '\t\t\t\t\t\t<div class="water water2"></div>\n' +
                '\t\t\t\t\t\t<div class="water water3"></div>\n' +
                '\t\t\t\t\t\t<div class="water water4"></div>\n' +
                '\t\t\t\t ');
            $('.page_3 .container').append($htetml);
            $('.page_3 .zhong_img').addClass('dongqi');
            setTimeout(function () {
                $htetml.remove();
            }, 6000)
            setTimeout(function () {
                $('.page_3 .zhong_img').removeClass('dongqi');
            }, 4000)
        })
        $('.page_3 .jinruzhuye').click(function () {
            $('.page_3').hide();
            $('.page_4').show();
            modal.page_4();
        })
    }

    //首页
    modal.page_4 = function () {

        nav_animation();

        // 领导致辞
        $('#nav-item1').unbind('click').on('click', function () {
            $('.page_4').hide();
            $('.page_5').show();
            modal.page_5();

        })

        // 奏唱国歌
        $('#nav-item2').unbind('click').on('click', function () {
            $('.page_4').hide();
            $('.page_6').show();
            modal.page_6();

        })

        // 往昔回顾
        $('#nav-item3').unbind('click').on('click', function () {
            $('.page_4').hide();
            $('.page_7').show();
            modal.page_7();

        })


        // 主题歌曲
        $('#nav-item4').unbind('click').on('click', function () {
            $('.page_4').hide();
            $('.page_8').show();
            modal.page_8();

        })

        // 诗歌朗诵
        $('#nav-item5').unbind('click').on('click', function () {
            $('.page_4').hide();
            $('.page_9').show();
            modal.page_9();

        })

        // 有奖问答
        $('#nav-item6').unbind('click').on('click', function () {
            $('.page_4').hide();
            $('.page_10').show();
            modal.page_10();

        })


        // 留言板
        $('#nav-item7').unbind('click').on('click', function () {
            $('.page_4').hide();
            $('.page_11').show();
            modal.page_11();

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
            $('.page_5').hide();
            $('.page_4').show();
            modal.page_4();

        })
    }

    modal.page_6 = function () {
        $('.cipan').unbind('click').on('click', function () {
            if ($(this).hasClass('rotate')) {
                var status = $(this).css('animation-play-state');
                console.log(status);
                if (status == 'running') {
                    //todo 暂停

                    $(this).css('animation-play-state', 'paused');
                } else {
                    //todo 播放
                    $(this).css('animation-play-state', 'running');

                }

            } else {
                //todo 播放

                $(this).addClass('rotate');
            }
        })


        $('.page_6 .goindex').unbind('click').on('click', function () {
            $('.page_6').hide();
            //暂停播放
            if ($('.cipan').css('animation-play-state') == 'running') {
                $('.cipan').css('animation-play-state', 'paused');
            }


            $('.page_4').show();
            modal.page_4();


        })
    }

    modal.page_7 = function () {
        $('.page_7 .goindex').unbind('click').on('click', function () {
            $('.page_7').hide();
            $('.page_4').show();
            modal.page_4();

        })






        var swiper = new swipers('.swiper-container', {
            watchSlidesProgress: true,
            slidesPerView: 'auto',
            centeredSlides: true,
            loop: true,
            loopedSlides: 3,
            autoplay: true,

            on: {
                progress: function(progress) {
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
                setTransition: function(transition) {
                    for (var i = 0; i < this.slides.length; i++) {
                        var slide = this.slides.eq(i)
                        slide.transition(transition);
                    }

                }

            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true,
            },
        });
    }

    modal.page_8 = function () {
        $('.page_8 .goindex').unbind('click').on('click', function () {
            $('.page_8').hide();
            $('.page_4').show();
            modal.page_4();

        })
    }

    modal.page_9 = function () {
        $('.page_9 .goindex').unbind('click').on('click', function () {
            $('.page_9').hide();
            $('.page_4').show();
            modal.page_4();

        })
    }
    modal.page_10 = function () {

        var swp = new swipers('.page_10 .swiper-container', {
            allowTouchMove:false,
            on:{
                reachEnd: function(){
                    $('#btn2').hide();
                    $('.submit').show();
                },
            },
        });

        /*  var turnplate={
              restaraunts:[],				//大转盘奖品名称
              colors:[],					//大转盘奖品区块对应背景颜色
              outsideRadius:192,			//大转盘外圆的半径
              textRadius:155,				//大转盘奖品位置距离圆心的距离
              insideRadius:68,			//大转盘内圆的半径
              startAngle:0,				//开始角度
              bRotate:false				//false:停止;ture:旋转
          };

          $(document).ready(function(){
              //动态添加大转盘的奖品与奖品区域背景颜色
              turnplate.restaraunts = ["318","特别奖<<中英街往事纪念书刊>>","31.8","谢谢参与","3.18","谢谢参与","3.18","谢谢参与"];
              turnplate.colors = ["#6AC334", "#62C2A1", "#218E9E", "#62C2A1","#758792","#62C2A1","#758792","#62C2A1"];


              var rotateTimeOut = function (){
                  $('#wheelcanvas').rotate({
                      angle:0,
                      animateTo:2160,
                      duration:8000,
                      callback:function (){
                          alert('网络超时，请检查您的网络设置！');
                      }
                  });
              };

              //旋转转盘 item:奖品位置; txt：提示语;
              var rotateFn = function (item, txt){
                  var angles = item * (360 / turnplate.restaraunts.length) - (360 / (turnplate.restaraunts.length*2));
                  if(angles<270){
                      angles = 270 - angles;
                  }else{
                      angles = 360 - angles + 270;
                  }
                  $('#wheelcanvas').stopRotate();
                  $('#wheelcanvas').rotate({
                      angle:0,
                      animateTo:angles+1800,
                      duration:8000,
                      callback:function (){

                          var arry = ["白云边20年45度", "关公坊红运", "黄鹤楼15年42度", "国宝桥米", "陈克明高筋宽带挂面", "金沙河麦芯龙须挂面", "雪花勇闯天涯听装", "康师傅冰红茶(柠檬味)", "脉动（芒果味）","奥星双低农家小榨","金龙鱼调和油","中昌非转基因食用调和油"];

                          for (var i = arry.length - 1; i >= 0; i--) {
                              if (arry[i].indexOf(txt) >= 0) {
                                  alert(arry[i])

                              }
                          }
                          turnplate.bRotate = !turnplate.bRotate;
                      }
                  });
              };

              $('.pointer').click(function (){
                  if(turnplate.bRotate)return;
                  turnplate.bRotate = !turnplate.bRotate;
                  //获取随机数(奖品个数范围内)
                  var item = rnd(1,turnplate.restaraunts.length);
                  //奖品数量等于10,指针落在对应奖品区域的中心角度[252, 216, 180, 144, 108, 72, 36, 360, 324, 288]
                  rotateFn(item, turnplate.restaraunts[item-1]);
                  /!* switch (item) {
                      case 1:
                          rotateFn(252, turnplate.restaraunts[0]);
                          break;
                      case 2:
                          rotateFn(216, turnplate.restaraunts[1]);
                          break;
                      case 3:
                          rotateFn(180, turnplate.restaraunts[2]);
                          break;
                      case 4:
                          rotateFn(144, turnplate.restaraunts[3]);
                          break;
                      case 5:
                          rotateFn(108, turnplate.restaraunts[4]);
                          break;
                      case 6:
                          rotateFn(72, turnplate.restaraunts[5]);
                          break;
                      case 7:
                          rotateFn(36, turnplate.restaraunts[6]);
                          break;
                      case 8:
                          rotateFn(360, turnplate.restaraunts[7]);
                          break;
                      case 9:
                          rotateFn(324, turnplate.restaraunts[8]);
                          break;
                      case 10:
                          rotateFn(288, turnplate.restaraunts[9]);
                          break;
                  } *!/
                  console.log(item);
              });
          });*/

        /*
        //控制中奖结果
                function rnd(n, m){
                    var random = 11;
                    //var random = Math.floor(Math.random()*(m-n+1)+n);
                    return random;

                }


        //页面所有元素加载完毕后执行drawRouletteWheel()方法对转盘进行渲染
                window.onload=function(){
                    drawRouletteWheel();
                };

                function drawRouletteWheel() {
                    var canvas = document.getElementById("wheelcanvas");
                    if (canvas.getContext) {
                        //根据奖品个数计算圆周角度
                        var arc = Math.PI / (turnplate.restaraunts.length/2);
                        var ctx = canvas.getContext("2d");
                        //在给定矩形内清空一个矩形
                        ctx.clearRect(0,0,422,422);
                        //strokeStyle 属性设置或返回用于笔触的颜色、渐变或模式
                        ctx.strokeStyle = "#FFBE04";
                        //font 属性设置或返回画布上文本内容的当前字体属性
                        ctx.font = '0.8rem Microsoft YaHei';
                        for(var i = 0; i < turnplate.restaraunts.length; i++) {
                            var angle = turnplate.startAngle + i * arc;
                            ctx.fillStyle = turnplate.colors[i];
                            ctx.beginPath();
                            //arc(x,y,r,起始角,结束角,绘制方向) 方法创建弧/曲线（用于创建圆或部分圆）
                            ctx.arc(211, 211, turnplate.outsideRadius, angle, angle + arc, false);
                            ctx.arc(211, 211, turnplate.insideRadius, angle + arc, angle, true);
                            ctx.stroke();
                            ctx.fill();
                            //锁画布(为了保存之前的画布状态)
                            ctx.save();

                            //----绘制奖品开始----
                            ctx.fillStyle = "#fff";
                            var text = turnplate.restaraunts[i];
                            var line_height = 17;
                            //translate方法重新映射画布上的 (0,0) 位置
                            ctx.translate(211 + Math.cos(angle + arc / 2) * turnplate.textRadius, 211 + Math.sin(angle + arc / 2) * turnplate.textRadius);

                            //rotate方法旋转当前的绘图
                            ctx.rotate(angle + arc / 2 + Math.PI / 2);

                            /!** 下面代码根据奖品类型、奖品名称长度渲染不同效果，如字体、颜色、图片效果。(具体根据实际情况改变) **!/
                            if(text.indexOf("M")>0){//流量包
                                var texts = text.split("M");
                                for(var j = 0; j<texts.length; j++){
                                    ctx.font = j == 0?'bold 0.8rem Microsoft YaHei':'0.8rem Microsoft YaHei';
                                    if(j == 0){
                                        ctx.fillText(texts[j]+"M", -ctx.measureText(texts[j]+"M").width / 2, j * line_height);
                                    }else{
                                        ctx.fillText(texts[j], -ctx.measureText(texts[j]).width / 2, j * line_height);
                                    }
                                }
                            }else if(text.indexOf("M") == -1 && text.length>6){//奖品名称长度超过一定范围
                                text = text.substring(0,4)+"||"+text.substring(4,8)+"||"+text.substring(8,12)+text.substring(4,8)+"||";
                                var texts = text.split("||");
                                console.log(texts)
                                for(var j = 0; j<texts.length; j++){
                                    ctx.fillText(texts[j], -ctx.measureText(texts[j]).width / 2, j * line_height);
                                }
                            }else{
                                //在画布上绘制填色的文本。文本的默认颜色是黑色
                                //measureText()方法返回包含一个对象，该对象包含以像素计的指定字体宽度

                                ctx.fillText(text, -ctx.measureText(text).width / 2, 0);
                            }

                            //添加对应图标
                           /!* if(text.indexOf("闪币")>0){
                                var img= document.getElementById("shan-img");
                                img.onload=function(){
                                    ctx.drawImage(img,-15,10);
                                };
                                ctx.drawImage(img,-15,10);
                            }else if(text.indexOf("谢谢参与")>=0){*!/
                               /!* var img= document.getElementById("sorry-img");
                                img.onload=function(){
                                    ctx.drawImage(img,-15,10);
                                };
                                ctx.drawImage(img,-15,10);*!/
                            // }
                            //把当前画布返回（调整）到上一个save()状态之前
                            ctx.restore();
                            //----绘制奖品结束----
                        }
                    }
                }

        */


        $('#btn2').unbind('click').on('click', function () {
            swp.slideNext();
        })


        $('.page_10 .submit').unbind('click').on('click', function () {
            // $.ajax()
            $('.page_10 .content1').hide();
            $('.page_10 .content2').show();

        })

        $('.page_10 .draw_start_btn').unbind('click').on('click',function () {
            $('.page_10 .draw').css('animation', 'drawrotate 0.5s linear infinite');
            //抽奖
            setTimeout(function () {
                $('.page_10 .draw').css('animation-play-state', 'paused');
                alert('获得特等级');
            },1000)
        })



        $('.page_10 .goindex').unbind('click').on('click', function () {
            $('.page_10').hide();
            $('.page_4').show();
            modal.page_4();

        })

    }

    modal.page_11 = function () {
        var swiper = new swipers('.page_11 .swiper-container', {
            direction : 'vertical',
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev',
            },
        });

        $('.page_11 .goindex').unbind('click').on('click', function () {
            $('.page_11').hide();
            $('.page_4').show();
            modal.page_4();

        })
    }

    return modal
});