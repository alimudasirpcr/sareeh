<script type="text/javascript">


				function reload_page(){
					$.ajax({
								url: '<?php echo site_url("sales/sales_reload/"); ?>', // URL to the controller method
								type: 'GET', // Use GET or POST as required
								success: function(response) {
									$("#sales_section").html(response); // Load the response into the div
								},
								error: function(xhr, status, error) {
									console.error('AJAX Error: ' + status + error); // Handle errors
								}
							});
				}

				

			$(document).ready(function() {
					$('#finish_sale_form').on('submit', function(e) {
						e.preventDefault(); // Prevent the default form submission

						// Serialize the form data
						var formData = $(this).serialize();

						// Make the AJAX request
						$.ajax({
							type: 'POST',
							url: $(this).attr('action'), // Form action URL
							data: formData,
							success: function(response) {
								$.ajax({
									type: 'POST',
									url:'<?php echo site_url("sales/preview_receipt/"); ?>'+response+'', // Form action URL
									data: formData,
									success: function(responseinner) {
										$('#grid-loader').hide();
										$('#ajaxreceiptbody').html('');
										$('#ajaxreceiptbody').html(responseinner);
										$('#ajaxreceipt').modal('show');
										setTimeout(function() {
										var contentHeight = $('#receipt_wrapper').prop('scrollHeight');
											$('#receipt_wrapper').height(contentHeight);
										}, 300);

										
										reload_page();


										function get_height(style) {

											style = style.replace(/ /g, '');

											var match = style.match(/height:\s*(\d+(\.\d+)?%);/);
											return match ? parseFloat(match[1]) : 0;
											}

											function setReceiptWrapperHeight() {
														// Get the total height of the content inside the div
														var contentHeight = $('#receipt_wrapper').prop('scrollHeight');
														// console.log('receipt_wrapper', contentHeight);
														// Set the height of the div to the content height
														$('#receipt_wrapper').height(contentHeight);
													}

									

														function updateVisibility() {
															['header', 'footer'].forEach(function(section) {
																var allPages = $('#' + section + '_all_pages').is(':checked');
																var firstPage = $('#' + section + '_first_pages').is(':checked');
																var lastPage = $('#' + section + '_last_pages').is(':checked');

																// Retrieve pages from the specific container
																var pagesContainer = $('.pages');
																var pages = pagesContainer.find('.page_' + section);
																var totalPages = pages.length;
																console.log(totalPages);
																pages.each(function(index) {
																	var $this = $(this);
																	var isFirstPage = index === 0; // First page in the container
																	var isLastPage = index === totalPages - 1; // Last page in the container

																	var relevantCheckbox = isFirstPage ? firstPage : (isLastPage ? lastPage :
																		allPages);
																	$this.find('.already_shown').toggle(relevantCheckbox);
																	$this.find('.resize').toggle(relevantCheckbox);
																	setBorderAndHeight($this, relevantCheckbox, section, isFirstPage, isLastPage,
																		index);
																});
															});


															function adjustTableBodies() {
																var pages = $('.pages');
																var changeMade = false;
																var originalLastFooter = $('.'+receipt_size+':last .page_footer')
																	.clone(); // Clone the footer of the original last page before changes

																function distributeBodies() {
																	pages.each(function() {
																		var $page = $(this);
																		var $bodies = $page.find('.page_body tbody');
																		var pageBodyHeight = $page.find('.page_body').height() - 300;

																		var usedHeight = 0;

																		$bodies.each(function() {
																			usedHeight += $(this).outerHeight(true);
																		});

																		var nextPage = $page.next('.'+receipt_size);
																		if (usedHeight < pageBodyHeight && nextPage.length > 0) {
																			var $nextBodies = nextPage.find('.page_body tbody');
																			var neededHeight = pageBodyHeight - usedHeight;
																			$nextBodies.each(function() {
																				var $body = $(this);
																				if ($body.outerHeight(true) <= neededHeight) {
																					$page.find('.page_body table').append($body);
																					neededHeight -= $body.outerHeight(true);
																					changeMade = true;
																					if (neededHeight <= 0)
																						return false; // break the loop if no more space needed
																				}
																			});
																		}
																	});
																}

																function removeEmptyPages() {
																	pages.each(function() {
																		var $page = $(this);
																		if ($page.find('.page_body tbody').length === 0) {
																			$page.remove();
																			changeMade = true;
																		}
																	});
																}
																
																function adjustLastPageLayout() {

																	var $lastPage = $('.'+receipt_size+':last');
																	// var headerHeight = $lastPage.find('.page_header').outerHeight(true);

																	headerHeight = $lastPage.find('.page_header').attr('style');
																	headerHeight = get_height(headerHeight);
																	footerHeight = originalLastFooter.attr('style');
																	footerHeight = get_height(footerHeight);

																	var availableHeight = 100 - headerHeight - footerHeight; // Assuming the total height is 100%
																	console.log('availableHeight', availableHeight);
																	$lastPage.find('.page_body').css('height', availableHeight + '%');
																	applyFooterToLastPage();
																}

																function applyFooterToLastPage() {
																	var $lastPageFooter = $('.'+receipt_size+':last .page_footer');
																	$lastPageFooter.replaceWith(originalLastFooter);


																	var div = $(".page-one").find(".page_header");
																	var maxHeight = 0;

																	// Iterate through each absolutely positioned child
																	div.children().each(function() {
																		// Calculate the bottom position of the child element
																		var bottomPosition = $(this).position().top + $(this).outerHeight(true);

																		// Update maxHeight if needed
																		if (bottomPosition > maxHeight) {
																			maxHeight = bottomPosition;
																		}
																	});

																	var div = $(".page-one").find(".page_body");
																	var maxHeight = 0;

																	// Iterate through each absolutely positioned child
																	div.children().each(function() {
																		// Calculate the bottom position of the child element
																		var bottomPosition = $(this).position().top + $(this).outerHeight(true);

																		// Update maxHeight if needed
																		if (bottomPosition > maxHeight) {
																			maxHeight = bottomPosition;
																		}
																	});

																	// Set the height of .page_header to the calculated maxHeight
																	div.height(maxHeight);

																}

																do {
																	changeMade = false;
																	distributeBodies();
																	removeEmptyPages();
																	pages = $('.'+receipt_size+''); // Refresh the list of pages in case any were removed
																} while (changeMade);

																adjustLastPageLayout(); // Adjust the layout of the last page after redistribution
															}

															// Run initially and on window resize

															setReceiptWrapperHeight();

															
															adjustTableBodies();



															$(window).resize(adjustTableBodies);



														}

												function setBorderAndHeight(element, isVisible, section, isFirstPage, isLastPage, index) {
													var borderProperty = (section == 'header') ? 'border-bottom' : 'border-top';
													var reverseborderProperty = (section == 'header') ? 'border-top' :
														'border-bottom';
													var borderStyle = isVisible ? '2px solid black' : 'none';
													// console.log('index='+index+'=section='+section+'=borderStyle='+borderStyle );
													if (borderStyle == 'none') {
														checkheigh = element.attr('style');
														if (get_height(checkheigh)) {
															if (section == 'header') {

																var inputValue = parseFloat($('#header-value-input').val()
																	.replace('%', ''));
																var style = element.siblings('.page_body').attr('style');
																var currentHeight = get_height(style);
																var newHeight = currentHeight + inputValue;
																element.siblings('.page_body').css('height', newHeight +
																	'%');
															} else {

																var inputValue = parseFloat($('#footer-value-input').val()
																	.replace('%', ''));
																var style = element.siblings('.page_body').attr('style');
																var currentHeight = get_height(style);
																var newHeight = currentHeight + inputValue;
																element.siblings('.page_body').css('height', newHeight +
																	'%');
															}

														}
														element.css('height', '0%');

													} else {
														checkheigh = element.attr('style');
														// console.log('checkheigh', checkheigh);
														if (!get_height(checkheigh)) {
															if (section == 'header') {


																var inputValue = parseFloat($('#header-value-input').val()
																	.replace('%', ''));
																var style = element.siblings('.page_body').attr('style');
																// console.log(style);
																var currentHeight = get_height(style);
																var newHeight = currentHeight - inputValue;
																// console.log('header', currentHeight);
																element.siblings('.page_body').css('height', newHeight +
																	'%');
															} else {

																var inputValue = parseFloat($('#footer-value-input').val()
																	.replace('%', ''));
																var style = element.siblings('.page_body').attr('style');
																var currentHeight = get_height(style);
																var newHeight = currentHeight - inputValue;
																element.siblings('.page_body').css('height', newHeight +
																	'%');
															}

														}

														if (section == 'header') {
															element.css('height', $('#header-value-input').val());

														} else {
															element.css('height', $('#footer-value-input').val());
														}

													}
													// Apply border style based on the page

													if (isFirstPage || isLastPage || $('.page_' + section).length === 1) {

														element.css(borderProperty, borderStyle);
														element.siblings('.page_body').css(reverseborderProperty, borderStyle);
													} else {
														if (!isFirstPage && !isLastPage) {

															element.css(borderProperty, borderStyle);
															element.siblings('.page_body').css(reverseborderProperty, borderStyle);
														}


													}



												}

												$('.section_checkbox').on('change', updateVisibility);
												updateVisibility(); // Initial visibility update
											

										setTimeout(function() {
											console.log('updateVisibility');
											updateVisibility();
                                        }, 3000);
										

									},
									error: function(xhr, status, error) {
										// Handle any errors
										console.error('AJAX Error: ' + status + error);
									}
								});
							},
							error: function(xhr, status, error) {
								// Handle any errors
								console.error('AJAX Error: ' + status + error);
							}
						});
					});
				});
				</script>