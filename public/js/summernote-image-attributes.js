
/* https://github.com/adeelhussain/summernote-image-attribute-editor */
(function (factory) {

	if (typeof define === 'function' && define.amd) {
		define(['jquery'], factory)
	} else if (typeof module === 'object' && module.exports) {
		module.exports = factory(require('jquery'));
	} else {
		factory(window.jQuery)
	}
}
	(function (jQuery) {
		// TODO: Add more languages!
		jQuery.extend(true, jQuery.summernote.lang, {
			'en-US': {
				imageAttributes: {
					edit: 'Edit Attributes',
					titleLabel: 'Title',
					altLabel: 'Alternative Text',
					captionLabel: 'Caption',
					tooltip: 'Edit Image',
					dialogSaveBtnMessage: 'Save',
					dialogTitle: 'Change Image Attributes'
				}
			}
		});
		jQuery.extend(jQuery.summernote.options, {
			imageAttributes: {
				icon: '<i class="note-icon"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 14 14" width="14" height="14"><path d="M 8.781,11.11 7,11.469 7.3595,9.688 8.781,11.11 Z M 7.713,9.334 9.135,10.7565 13,6.8915 11.5775,5.469 7.713,9.334 Z M 6.258,9.5 8.513,7.12 7.5,5.5 6.24,7.5 5,6.52 3,9.5 6.258,9.5 Z M 4.5,5.25 C 4.5,4.836 4.164,4.5 3.75,4.5 3.336,4.5 3,4.836 3,5.25 3,5.6645 3.336,6 3.75,6 4.164,6 4.5,5.6645 4.5,5.25 Z m 1.676,5.25 -4.176,0 0,-7 9,0 0,1.156 1,0 0,-2.156 -11,0 0,9 4.9845,0 0.1915,-1 z"/></svg></i>',
				figureClass: '',
				figcaptionClass: '',
				captionText: 'Caption Goes Here.'
			}
		});
		jQuery.extend(jQuery.summernote.plugins, {
			'imageAttributes': function (context) {
				var self = this;
				var ui = jQuery.summernote.ui,
					jQueryeditable = context.layoutInfo.editable,
					options = context.options,
					jQueryeditor = context.layoutInfo.editor,
					lang = options.langInfo,
					jQuerynote = context.layoutInfo.note;

				context.memo('button.imageAttributes', function () {
					var button = ui.button({
						contents: options.imageAttributes.icon,
						container: false,
						tooltip: lang.imageAttributes.tooltip,
						click: function () {
							context.invoke('imageAttributes.show');
						}
					});
					return button.render();
				});

				this.initialize = function () {
					// Either the modal appends in Body or Inside the Editor
					var jQuerycontainer = options.imageAttributes.dialogsInBody ? jQuery(document.body) : jQueryeditor;

					var body = ` <div class="form-group">
									<label class="note-form-label">${lang.imageAttributes.titleLabel}</label>
									<input class="form-control note-input note-image-title-text" type="text" />
								</div>
								<div class="form-group">
									<label class="note-form-label">${lang.imageAttributes.altLabel}</label>
									<input class="form-control note-input note-image-alt-text" type="text" />
								</div>
								<div class="form-group">
									<label class="note-form-label">${lang.imageAttributes.captionLabel}</label>
									<input class="form-control note-input note-image-caption-text" type="text" />
								</div>
								<div class="row">
									<div class="form-group col-sm-4">
										<label class="note-form-label">${lang.imageAttributes.widthLabel}</label>
										<input class="form-control note-input note-image-width" type="number" />
									</div>
									<div class="form-group col-sm-4">
										<label class="note-form-label">${lang.imageAttributes.heightLabel}</label>
										<input class="form-control note-input note-image-height" type="number" />
									</div>

								</div>`;

					var footer = `<button href="#" class="btn btn-primary note-image-title-btn note-btn">${lang.imageAttributes.dialogSaveBtnMessage}</button>`;

					this.jQuerydialog = ui.dialog({
						title: lang.imageAttributes.dialogTitle,
						body: body,
						footer: footer
					}).render().appendTo(jQuerycontainer);

				};

				this.destroy = function () {
					ui.hideDialog(this.jQuerydialog);
					this.jQuerydialog.remove();
				};

				this.bindEnterKey = function (jQueryinput, jQuerybtn) {
					jQueryinput.on('keypress', function (event) {
						if (event.keyCode === 13) {
							jQuerybtn.trigger('click');
						}
					});
				};

				this.show = function () {
					var jQueryimg = jQuery(jQueryeditable.data('target'));
					var _imgInfo = {
						title: jQueryimg.attr('title'),
						alt: jQueryimg.attr('alt'),
						caption: jQueryimg.next('figcaption').text(),
						width: jQueryimg.width(),
						height: jQueryimg.height()
					};

					var img = new Image();
					img.onload = function () {
						_imgInfo.naturalWidth = img.width
						_imgInfo.naturalHeight = img.height;
					}
					img.src = jQueryimg.attr('src');


					this.showLinkDialog(_imgInfo)
						.then(function (imgInfo) {
							ui.hideDialog(self.jQuerydialog);
							var isAnyChangeMade = false;

							// NOTE: Must add more conditions if any new field is being added!
							if (_imgInfo.title != imgInfo.title || _imgInfo.alt != imgInfo.alt || _imgInfo.caption != imgInfo.caption
								|| _imgInfo.width != imgInfo.width || _imgInfo.height != imgInfo.height) {
								isAnyChangeMade = true;
							}

							if (imgInfo.alt) {
								jQueryimg.attr('alt', imgInfo.alt);
							}
							else {
								jQueryimg.removeAttr('alt');
							}

							if (imgInfo.title) {
								jQueryimg.attr('title', imgInfo.title);
							}
							else {
								jQueryimg.removeAttr('title');
							}

							if (imgInfo.width) {
								jQueryimg.css('width', imgInfo.width);
							}

							if (imgInfo.height) {
								jQueryimg.css('height', imgInfo.height);
							}

							var captionText = imgInfo.caption;
							var jQueryparentAnchorLink = jQueryimg.parent();

							// If caption are not same, then its mean need to update!
							var isUpdateCaption = (captionText !== _imgInfo.caption);

							// If image already have a caption and is equal to old one, then remove that!
							var jQueryimgFigure = jQueryimg.closest('figure');
							if (jQueryimgFigure.length && isUpdateCaption) {

								// Means image wrpped in figure
								jQueryimgFigure.find('figcaption').remove();
								jQueryimgFigure.children().first().unwrap();

							}

							// If caption text is present then add that caption, otherwise don't do any thing
							if (isUpdateCaption && captionText) {
								var jQuerynewFigure;
								if (jQueryparentAnchorLink.is('a')) {
									jQuerynewFigure = jQueryparentAnchorLink.wrap(`<figure class="jQuery{options.imageAttributes.figureClass}"></figure>`).parent();
									jQuerynewFigure.append(`<figcaption class="jQuery{options.imageAttributes.figcaptionClass}"> jQuery{captionText}</figcaption>`);
								} else {
									jQuerynewFigure = jQueryimg.wrap(`<figure class="jQuery{options.imageAttributes.figureClass}"></figure>`).parent();
									jQueryimg.after(`<figcaption class="jQuery{options.imageAttributes.figcaptionClass}">jQuery{captionText}</figcaption>`);
								}
							}

							if (isAnyChangeMade) {
								var _content = context.invoke('code');

								jQuerynote.val(_content);
								jQuerynote.trigger('summernote.change', _content);
							}

						});
				};

				this.showLinkDialog = function (imgInfo) {
					return jQuery.Deferred(function (deferred) {
						var jQueryimageTitle = self.jQuerydialog.find('.note-image-title-text');
						var jQueryimageCaption = self.jQuerydialog.find('.note-image-caption-text');
						var jQueryimageAlt = self.jQuerydialog.find('.note-image-alt-text');
						var jQueryeditBtn = self.jQuerydialog.find('.note-image-title-btn');
						var jQueryimageWidthInput = self.jQuerydialog.find('.note-image-width');
						var jQueryimageHeightInput = self.jQuerydialog.find('.note-image-height');
						var jQuerylockButton = self.jQuerydialog.find('.lock-button');
						var jQueryresetSizeButton = self.jQuerydialog.find('.reset-size-buttton');
						var jQueryunlockIcon = jQuerylockButton.find('.icon-unlock');
						var jQuerylockIcon = jQuerylockButton.find('.icon-lock');

						var isLocked = (typeof options.imageAttributes.manageAspectRatio === 'undefined') ? true: options.imageAttributes.manageAspectRatio;
						if(isLocked){
							jQueryunlockIcon.addClass('hide').removeClass('show');
							jQuerylockIcon.addClass('show').removeClass('hide');
						}
						else {
							jQueryunlockIcon.addClass('show').removeClass('hide');
							jQuerylockIcon.addClass('hide').removeClass('show');
						}

						jQuerylockButton.on('click', function (event) {
							event.preventDefault();
							isLocked = !isLocked;

							if (isLocked) {

								jQueryunlockIcon.addClass('hide').removeClass('show')
								jQuerylockIcon.addClass('show').removeClass('hide')

								jQueryimageHeightInput.val(imageAdjustedHeight(jQueryimageWidthInput.val(), imgInfo.naturalWidth, imgInfo.naturalHeight));
							}
							else {

								jQueryunlockIcon.addClass('show').removeClass('hide')
								jQuerylockIcon.addClass('hide').removeClass('show')
							}
						});

						jQueryresetSizeButton.on('click', function (event) {
							event.preventDefault();
							jQueryimageWidthInput.val(imgInfo.width);
							jQueryimageHeightInput.val(imgInfo.height);
						});

						jQueryimageHeightInput.on("input", function () {
							if (isLocked) {
								jQueryimageWidthInput.val(imageAdjustedWidth(this.value, imgInfo.naturalWidth, imgInfo.naturalHeight));
							}
						});

						jQueryimageWidthInput.on("input", function () {
							if (isLocked) {
								jQueryimageHeightInput.val(imageAdjustedHeight(this.value, imgInfo.naturalWidth, imgInfo.naturalHeight));
							}
						});

						ui.onDialogShown(self.jQuerydialog, function () {
							context.triggerEvent('dialog.shown');

							jQueryeditBtn.on('click', function (event) {
								event.preventDefault();
								deferred.resolve({
									title: jQueryimageTitle.val(),
									alt: jQueryimageAlt.val(),
									caption: jQueryimageCaption.val(),
									width: jQueryimageWidthInput.val(),
									height: jQueryimageHeightInput.val(),
								});
							});

							jQueryimageTitle.val(imgInfo.title).trigger('focus');
							self.bindEnterKey(jQueryimageTitle, jQueryeditBtn);

							jQueryimageAlt.val(imgInfo.alt);
							self.bindEnterKey(jQueryimageAlt, jQueryeditBtn);

							jQueryimageCaption.val(imgInfo.caption);
							self.bindEnterKey(jQueryimageCaption, jQueryeditBtn);

							jQueryimageWidthInput.val(imgInfo.width);
							self.bindEnterKey(jQueryimageWidthInput, jQueryeditBtn);

							jQueryimageHeightInput.val(imgInfo.height);
							self.bindEnterKey(jQueryimageHeightInput, jQueryeditBtn);

						});

						ui.onDialogHidden(self.jQuerydialog, function () {
							jQueryeditBtn.off('click');
							jQueryimageWidthInput.off('input');
							jQueryimageHeightInput.off('input');
							jQuerylockButton.off('click');
							jQueryresetSizeButton.off('click');
							jQueryunlockIcon.off('click');
							jQuerylockIcon.off('click');


							if (deferred.state() === 'pending') {
								deferred.reject();
							}
						});
						ui.showDialog(self.jQuerydialog);
					});
				};

				function imageAdjustedHeight(heightInputValue, imageOriginalWidth, imageOriginalHeight) {
					return parseInt(heightInputValue * (imageOriginalHeight / imageOriginalWidth), 10)
				}

				function imageAdjustedWidth(widthInputValue, imageOriginalWidth, imageOriginalHeight) {
					return parseInt(widthInputValue * (imageOriginalWidth / imageOriginalHeight), 10)
				}
			}
		});
	}));
