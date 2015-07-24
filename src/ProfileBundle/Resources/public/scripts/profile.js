var Profile = function() {

    var dashboardMainChart = null;

    return {

        //main function
        init: function() {
        
            Profile.initMiniCharts();
            Profile.uploadUserPick();
        },

        initMiniCharts: function() {

            // IE8 Fix: function.bind polyfill
            if (Metronic.isIE8() && !Function.prototype.bind) {
                Function.prototype.bind = function(oThis) {
                    if (typeof this !== "function") {
                        // closest thing possible to the ECMAScript 5 internal IsCallable function
                        throw new TypeError("Function.prototype.bind - what is trying to be bound is not callable");
                    }

                    var aArgs = Array.prototype.slice.call(arguments, 1),
                        fToBind = this,
                        fNOP = function() {},
                        fBound = function() {
                            return fToBind.apply(this instanceof fNOP && oThis ? this : oThis,
                                aArgs.concat(Array.prototype.slice.call(arguments)));
                        };

                    fNOP.prototype = this.prototype;
                    fBound.prototype = new fNOP();

                    return fBound;
                };
            }

            $("#sparkline_bar").sparkline([8, 9, 10, 11, 10, 10, 12, 10, 10, 11, 9, 12, 11], {
                type: 'bar',
                width: '100',
                barWidth: 6,
                height: '45',
                barColor: '#F36A5B',
                negBarColor: '#e02222'
            });

            $("#sparkline_bar2").sparkline([9, 11, 12, 13, 12, 13, 10, 14, 13, 11, 11, 12, 11], {
                type: 'bar',
                width: '100',
                barWidth: 6,
                height: '45',
                barColor: '#5C9BD1',
                negBarColor: '#e02222'
            });

            //change hash tag
            $('.nav-tabs').find('[data-toggle = "tab"]').on('click', function () {
                var currentHash = $(this).attr('href');
                document.location.href = document.location.origin + document.location.pathname + currentHash;
            });
        },

        uploadUserPick: function(){
            $('.profile-userpic').find('img')
                .attr('title', 'Click for upload new image')
                .on('click', function(){
                    $("#Avatar").click();
            });

            $("#Avatar").change(function(){
                if ($('#Avatar').get(0).files[0].size<5000000) {
                    $("form#avatarForm").submit();
                } else {
                    alert('File size is too large.');
                }
            });

            $("form#avatarForm").ajaxForm({
                data: {},
                beforeSend: function() {},
                uploadProgress: function(event, position, total, percentComplete) {},
                complete: function(data) {
                    $("div.avatar img").attr('src', data.responseText).addClass('statPhoto');
                    $("div.avatarEdit img").attr('src', data.responseText).addClass('statPhoto');
                    $("#photo").val(data.responseText);

                },
                error: function(er){}
            });
        }

    };

}();