(function (factory) {
  if (typeof define === 'function' && define.amd) {
    // AMD. Register as anonymous module.
    define(['jquery'], factory);
  } else if (typeof exports === 'object') {
    // Node / CommonJS
    factory(require('jquery'));
  } else {
    // Browser globals.
    factory(jQuery);
  }
})(function ($) {

  'use strict';

  var console = window.console || { log: function () {} };

  function CropAvatar($element) {
    this.$container = $element;

    this.$avatarView = $(".bg-img-div");
    this.$avatarSubmit = $("#submit_btn");
    this.$avatarInputBannerImg = $(".avatar-input-banner-img")
    this.$avatar = this.$avatarView.find('img');
    this.$avatarModal = this.$container.find('#avatar-modal');
    this.$loading = this.$container.find('.loading');

    this.$avatarForm = this.$avatarModal.find('.avatar-form');
    this.$avatarUpload = this.$avatarForm.find('.avatar-upload');
    this.$avatarSrc = this.$avatarForm.find('.avatar-src');
    this.$avatarData = this.$avatarForm.find('.avatar-data');
    this.$avatarInput = this.$avatarForm.find('.avatar-input');
    this.$avatarInputBanner = this.$avatarForm.find('.avatar-input-banner');
    this.$avatarSave = this.$avatarForm.find('.avatar-save');
    this.$avatarBtns = this.$avatarForm.find('.avatar-btns');

    this.$avatarWrapper = this.$avatarModal.find('.avatar-wrapper');
    this.$avatarPreview = this.$avatarModal.find('.avatar-preview');

    this.init();
  }

  CropAvatar.prototype = {
    ajaxSubmit1 : 0,
    ajaxSubmit2 : 0,
    constructor: CropAvatar,

    support: {
      fileList: !!$('<input type="file">').prop('files'),
      blobURLs: !!window.URL && URL.createObjectURL,
      formData: !!window.FormData
    },

    init: function () {
      this.support.datauri = this.support.fileList && this.support.blobURLs;

      if (!this.support.formData) {
        this.initIframe();
      }

      this.initTooltip();
      this.initModal();
      this.addListener();
    },

    addListener: function () {
      this.$avatarView.on('click', $.proxy(this.click, this));
      this.$avatarInput.on('change', $.proxy(this.change, this));
      this.$avatarInputBanner.on('change', $.proxy(this.change_banner, this));
      this.$avatarSubmit.on('click', $.proxy(this.submit, this));
      this.$avatarBtns.on('click', $.proxy(this.rotate, this));
    },

    initTooltip: function () {
      this.$avatarView.tooltip({
        placement: 'bottom'
      });
    },

    initModal: function () {
        var _this = this;
        this.$avatarModal.modal({
            show: false
        });
        this.$avatarModal.on('hidden.bs.modal', function (e) {
            _this.$avatarInput.val('');
            _this.$avatarInputBanner.val('');
        })
    },

    initPreview: function () {
      var url = this.$avatar.attr('src');

      if(url != undefined && url != ""){
          $(".glyphicon-picture:gt(0)").hide();
      }

      this.$avatarPreview.html('<img src="' + url + '">');
    },

    initIframe: function () {
      var target = 'upload-iframe-' + (new Date()).getTime();
      var $iframe = $('<iframe>').attr({
            name: target,
            src: ''
          });
      var _this = this;

      // Ready ifrmae
      $iframe.one('load', function () {

        // respond response
        $iframe.on('load', function () {
          var data;

          try {
            data = $(this).contents().find('body').text();
          } catch (e) {
            console.log(e.message);
          }

          if (data) {
            try {
              data = $.parseJSON(data);
            } catch (e) {
              console.log(e.message);
            }

            _this.submitDone(data);
          } else {
            _this.submitFail('Image upload failed!');
          }

          _this.submitEnd();

        });
      });

      this.$iframe = $iframe;
      this.$avatarForm.attr('target', target).after($iframe.hide());
    },

    click: function () {
      this.$avatarModal.modal('show');
      this.initPreview();
    },
    change_banner: function(){
        var files;
        var file;

        if (this.support.datauri) {
            files = this.$avatarInputBanner.prop('files');

            if (files.length > 0) {
                file = files[0];

                if (this.isImageFile(file)) {
                    if (this.url) {
                        URL.revokeObjectURL(this.url); // Revoke the old one
                    }

                    this.url = URL.createObjectURL(file);
                    this.$avatarInputBannerImg.attr("src", this.url);
                }
            }
        } else {
            file = this.$avatarInputBanner.val();

            if (this.isImageFile(file)) {
                this.syncUpload();
            }
        }
    },
    change: function () {
      var files;
      var file;

      if (this.support.datauri) {
        files = this.$avatarInput.prop('files');

        if (files.length > 0) {
          file = files[0];

          if (this.isImageFile(file)) {
            if (this.url) {
              URL.revokeObjectURL(this.url); // Revoke the old one
            }

            this.url = URL.createObjectURL(file);
            this.startCropper();
          }
        }
      } else {
        file = this.$avatarInput.val();

        if (this.isImageFile(file)) {
          this.syncUpload();
        }
      }
    },

    submit: function () {
        /*
      if (!this.$avatarSrc.val() && !this.$avatarInput.val()) {
        return false;
      }*/

      if (this.support.formData) {
        this.ajaxUpload();
        return false;
      }
    },

    rotate: function (e) {
      var data;

      if (this.active) {
        data = $(e.target).data();

        if (data.method) {
          this.$img.cropper(data.method, data.option);
        }
      }
    },

    isImageFile: function (file) {
      if (file.type) {
        return /^image\/\w+$/.test(file.type);
      } else {
        return /\.(jpg|jpeg|png|gif)$/.test(file);
      }
    },

    startCropper: function () {
      var _this = this;

      if (this.active) {
        this.$img.cropper('replace', this.url);
      } else {
        this.$img = $('<img src="' + this.url + '">');
        this.$avatarWrapper.empty().html(this.$img);
        this.$img.cropper({
          aspectRatio: 1,
          preview: this.$avatarPreview.selector,
          strict: false,
          crop: function (e) {
            var json = [
                  '{"x":' + e.x,
                  '"y":' + e.y,
                  '"height":' + e.height,
                  '"width":' + e.width,
                  '"rotate":' + e.rotate + '}'
                ].join();

            _this.$avatarData.val(json);
          }
        });

        this.active = true;
      }

      this.$avatarModal.one('hidden.bs.modal', function () {
        _this.$avatarPreview.empty();
        _this.stopCropper();
      });
    },

    stopCropper: function () {
      if (this.active) {
        this.$img.cropper('destroy');
        this.$img.remove();
        this.active = false;
      }
    },

    ajaxUploadBack: function(){
        var _this = this;
        var company_id = $("#company_id").val();
        var logo = $("#company_logo").val();
        var banner = $("#company_banner").val();
        var record_is_show =$("[name='record_is_show']:checked").val();
        //提交按钮
        $.ajax({
            url : '/enterprise/default/edit-company',
            type : 'post',
            dataType : 'json',
            data : {
                id : company_id,
                logo : logo,
                banner : banner,
                record_is_show : record_is_show
            },
            success : function(){
                _this.uploaded = false;
                _this.stopCropper();
                _this.$avatarModal.modal('hide');

                _this.$avatarInput.val('');
                _this.$avatarInputBanner.val('');

                if(banner != "" && banner != undefined){
                    $(".enterprise-banner-bg").attr("src", banner);
                }
                if(logo != "" && banner != logo){
                    $(".company-logo").attr("src", logo);
                    _this.$avatarView.find("img").show();
                }
                if(record_is_show == 1){
                    $("#ent_record").show(200);
                }
                else{
                    $("#ent_record").hide(200);
                }
            }
        });


    },
    ajaxUpload: function () {
      var url = this.$avatarForm.attr('action');
      var data = new FormData(this.$avatarForm[0]);
      var _this = this;

      _this.ajaxSubmit1 = 0;
      _this.ajaxSubmit2 = 0;

        if(this.$avatarInput.val()){
            $.ajax(url, {
                type: 'post',
                data: data,
                dataType: 'json',
                processData: false,
                contentType: false,

                beforeSend: function () {
                    _this.submitStart();
                },

                success: function (data) {
                    _this.ajaxSubmit1 = 1;
                    if(!_this.$avatarInputBanner.val()){
                        _this.ajaxSubmit2 = 1;
                    }
                    $("#company_logo").val(data.result);
                    _this.submitDone(data);
                    if(_this.ajaxSubmit1 == 1 && _this.ajaxSubmit2 == 1){
                        _this.ajaxUploadBack(data);
                    }
                },

                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    _this.submitFail(textStatus || errorThrown);
                },

                complete: function () {
                    _this.submitEnd();
                }
            });
        }

        if(this.$avatarInputBanner.val()){
            this.$avatarForm.eq(1).submit();
            /*
            var url = this.$avatarForm.eq(1).attr('action');
            var data = new FormData(this.$avatarForm[1]);

            $.ajax(url, {
                type: 'get',
                data: data,
                dataType: 'jsonp',
                processData: false,
                contentType: false,

                beforeSend: function () {
                    _this.submitStart();
                },

                success: function (jsonp) {
                    var json = eval('(' + jsonp + ')');
                    _this.ajaxSubmit2 = 1;
                    if(!_this.$avatarInput.val()){
                        _this.ajaxSubmit1 = 1;
                    }
                    $("#company_banner").val(json.data.file_url);
                    //$("#company_banner").val(json.result);
                    if(_this.ajaxSubmit1 == 1 && _this.ajaxSubmit2 == 1){
                        _this.ajaxUploadBack();
                    }
                },

                error: function (XMLHttpRequest, textStatus, errorThrown) {
                    _this.submitFail(textStatus || errorThrown);
                },

                complete: function () {
                    _this.submitEnd();
                }
            });
            */
        }

        if(!this.$avatarInput.val() && !this.$avatarInputBanner.val()){
            _this.ajaxUploadBack();
        }
    },

    syncUpload: function () {
      this.$avatarSave.click();
    },

    submitStart: function () {
      this.$loading.fadeIn();
    },

    submitDone: function (data) {
      console.log(data);

      if ($.isPlainObject(data) && data.state === 200) {
        if (data.result) {
          this.url = data.result;

          if (this.support.datauri || this.uploaded) {
            this.uploaded = false;
            this.cropDone();
          } else {
            this.uploaded = true;
            this.$avatarSrc.val(this.url);
            this.startCropper();
          }

          this.$avatarInput.val('');
          this.$avatarInputBanner.val('');
        } else if (data.message) {
          this.alert(data.message);
        }
      } else {
        this.alert('Failed to response');
      }
    },

    submitFail: function (msg) {
      this.alert(msg);
    },

    submitEnd: function () {
      this.$loading.fadeOut();
    },

    cropDone: function () {
      this.$avatarForm.get(0).reset();
      this.$avatar.attr('src', this.url);
      this.stopCropper();
      this.$avatarModal.modal('hide');
    },

    alert: function (msg) {
      var $alert = [
            '<div class="alert alert-danger avatar-alert alert-dismissable">',
              '<button type="button" class="close" data-dismiss="alert">&times;</button>',
              msg,
            '</div>'
          ].join('');

      this.$avatarUpload.after($alert);
    }
  };

  $(function () {
      cropAvatar = new CropAvatar($('#crop-avatar'));
  });

});

var cropAvatar = null;
//保存文件url
function setfileurlfromcallback(fileurl) {
    cropAvatar.ajaxSubmit2 = 1;
    if(!cropAvatar.$avatarInput.val()){
        cropAvatar.ajaxSubmit1 = 1;
    }
    $("#company_banner").val(fileurl);

    if(cropAvatar.ajaxSubmit1 == 1 && cropAvatar.ajaxSubmit2 == 1){
        cropAvatar.ajaxUploadBack();
    }
}