<?php
$this->load->view("partial/header");
$img_logo_image = base_url() . 'assets/css_good/media/svg/avatars/blank.svg';
?>
<script src="<?php echo base_url(); ?>assets/css_good/plugins/custom/draggable/draggable.bundle.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/print-js/1.6.0/print.js"
    integrity="sha512-/fgTphwXa3lqAhN+I8gG8AvuaTErm1YxpUjbdCvwfTMyv8UZnFyId7ft5736xQ6CyQN4Nzr21lBuWWA9RTCXCw=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"
    integrity="sha512-BNaRQnYJYiPSqHHDb58B0yaPfCu+Wgds8Gp/gU33kqBtgNS4tSPHuGibyoeqMV/TJlSKda6FXzoEyYGjTe+vXA=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="<?= base_url() ?>/assets/css_good/plugins/custom/nouislider/dist/nouislider.min.js"></script>
<script src="<?= base_url() ?>/assets/css_good/plugins/custom/jkanban/jkanban.bundle.js"></script>
<style>
#kt_app_header {
    display: none !important;

}

.app-sidebar {
    width: 100px !important;
}



.required {
    color: black;
}




.draggable {
    width: 50px;
    height: 30px;
    cursor: move;
    position: absolute;
    padding: 0px;
}

#dropZone {
    min-height: 1123px;
    position: relative;
    margin: 0 auto;
    border: gray 1px solid;
}

.page_header {
    position: relative;
}

#items-drag {
    min-height: 300px;
    height: calc(100vh - 200px);
    overflow: hidden;
    overflow-y: scroll;
}

#img-list {
    min-height: 300px;
    height: calc(100vh - 200px);
    overflow: hidden;
    overflow-y: scroll;
}

.items-list {
    width: 100% !important;
}

.A4 {
    width: 210mm;
    height: 297mm;
    margin: 0 auto; // Centers the div if the print layout allows
    padding: 20mm; // Adjust padding as necessary
    box-sizing: border-box;
    background: white; // Ensures the background is white
    color: black; // Text color
    page-break-after: always; // Ensures each A4 div starts on a new page
}



.A4:last-child {
    page-break-after: avoid; // Prevents an extra blank page after the last div
}

.A3 {
    width: 260mm;
    height: 420mm;
}

.A5 {
    width: 148mm;
    height: 210mm;
}

.Letter {
    width: 216mm;
    height: 279mm;
}

.Legal {
    width: 216mm;
    height: 356mm;
}

.Executive {
    width: 184mm;
    height: 267mm;
}

.B4 {
    width: 250mm;
    height: 353mm;
}

.B5 {
    width: 176mm;
    height: 250mm;
}

.receipt_padd {
    margin: 0 auto;
    padding-left: 18px;
    padding-right: 17px;
}

/* Optional custom styling for popover */
.popover {
    max-width: 200px;
    /* Adjust the width of the popover */
}

.popover-header {
    font-weight: bold;
    /* Make the header text bold */
}

.popover-body {
    padding: 10px;
    /* Add padding for better spacing */
}

.popover-body .popover-item {
    display: flex;
    /* Ensure icons and text are aligned */
    align-items: center;
    /* Vertically align items */
    margin-bottom: 10px;
    /* Space between items */
}

.popover-body .popover-item svg {
    margin-right: 8px;
    /* Space between icon and text */
}

<?php if ($receipt['background_image']) {
    $img_background_image=cacheable_app_file_url($receipt['background_image']);
}

?>@media print {
    .elementWithBackground {

        background-position: center center !important;
        background-repeat: no-repeat !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
        background-image: url(<?php echo $img_background_image; ?>) !important;
        page-break-after: always !important;
    }

    .border_line {
        /* border-top: solid 1px black; */
        background-size: 210mm 1mm !important;
        background-color: black;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }



    .A4 {
        background-size: 210mm 297mm !important;
    }

    .A3 {
        background-size: 260mm 420mm !important;
    }

    .A5 {

        background-size: 148mm 210mm !important;
    }

    .Letter {

        background-size: 216mm 279mm !important;
    }

    .Legal {

        background-size: 216mm 356mm !important;
    }

    .Executive {

        background-size: 184mm 267mm !important;
    }

    .B4 {

        background-size: 250mm 353mm !important;
    }

    .B5 {
        background-size: 176mm 250mm !important;
    }
}
</style>
<?php $positions = (json_decode($receipt['positions'])) ? json_decode($receipt['positions']) : []; 

?>
<?php $checks = (json_decode($receipt['checks'])) ? json_decode($receipt['checks']) : []; ?>
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.js"></script>
<div class="docs-content d-flex flex-column flex-column-fluid" id="kt_docs_content">
    <!--begin::Container-->
    <div class=" p-0 d-flex flex-column flex-lg-row gap-2" id="kt_docs_content_container">
        <!--begin::Card-->
        <div class="card card-docs flex-row-fluid mb-2 w-25 menu-card d-none" id="shapes">
            <div class="card-header border-0 m-0 p-0 w-100">
                <div class="hidden-print w-100">
                    <div class="d-flex align-items-center  py-5 m-0 p-0 bg-light-info  ">
                        <!--begin::Icon-->
                        <div class="d-flex h-80px w-80px flex-shrink-0 flex-center position-relative ms-3 me-6">
                            <!--begin::Svg Icon | path: icons/duotune/abstract/abs051.svg-->
                            <span class="svg-icon svg-icon-info position-absolute opacity-10">
                                <svg class=". w-80px h-80px ." xmlns="http://www.w3.org/2000/svg" width="70px"
                                    height="70px" viewBox="0 0 70 70" fill="none">
                                    <path
                                        d="M28 4.04145C32.3316 1.54059 37.6684 1.54059 42 4.04145L58.3109 13.4585C62.6425 15.9594 65.3109 20.5812 65.3109 25.5829V44.4171C65.3109 49.4188 62.6425 54.0406 58.3109 56.5415L42 65.9585C37.6684 68.4594 32.3316 68.4594 28 65.9585L11.6891 56.5415C7.3575 54.0406 4.68911 49.4188 4.68911 44.4171V25.5829C4.68911 20.5812 7.3575 15.9594 11.6891 13.4585L28 4.04145Z"
                                        fill="currentColor"></path>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--begin::Svg Icon | path: icons/duotune/art/art006.svg-->
                            <span class="svg-icon svg-icon-3x svg-icon-info position-absolute">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3" d="M5 8.04999L11.8 11.95V19.85L5 15.85V8.04999Z"
                                        fill="currentColor" />
                                    <path
                                        d="M20.1 6.65L12.3 2.15C12 1.95 11.6 1.95 11.3 2.15L3.5 6.65C3.2 6.85 3 7.15 3 7.45V16.45C3 16.75 3.2 17.15 3.5 17.25L11.3 21.75C11.5 21.85 11.6 21.85 11.8 21.85C12 21.85 12.1 21.85 12.3 21.75L20.1 17.25C20.4 17.05 20.6 16.75 20.6 16.45V7.45C20.6 7.15 20.4 6.75 20.1 6.65ZM5 15.85V7.95L11.8 4.05L18.6 7.95L11.8 11.95V19.85L5 15.85Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Icon-->
                        <!--begin::Description-->


                        <div class="kt-primary fw-bold fs-3 lh-lg">
                            Shapes and lines
                            <div class=" fs-6 fw-normal">drag and drop the element in workspace area </div>

                        </div>
                        <!--end::Description-->
                    </div>
                </div>
            </div>
            <div class="card-body fs-6  text-gray-700" style="padding: 0px;">
                <div class="d-flex gap-1 my-3 mx-2">

                    <div class="rectangle">
                        <span class="svg-icon svg-icon-gray-800 svg-icon-2hx shape-action" data-placement="bottom"
                            data-toggle="popover" data-html="true" data-content="
											<div class='popover-header'>header</div>
												<div class='popover-body w-175px p-0'>
												<span class='svg-icon svg-icon-muted svg-icon-2hx'><svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
								<path opacity='0.3' d='M22 5V19C22 19.6 21.6 20 21 20H19.5L11.9 12.4C11.5 12 10.9 12 10.5 12.4L3 20C2.5 20 2 19.5 2 19V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5ZM7.5 7C6.7 7 6 7.7 6 8.5C6 9.3 6.7 10 7.5 10C8.3 10 9 9.3 9 8.5C9 7.7 8.3 7 7.5 7Z' fill='currentColor'/>
								<path d='M19.1 10C18.7 9.60001 18.1 9.60001 17.7 10L10.7 17H2V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V12.9L19.1 10Z' fill='currentColor'/>
								</svg>
								</span>
													Insert into 
													<div class='d-flex gap-1'>
													<div class='popover-item btn btn-primary btn-xsm' onclick='add_rect(&#34;rectangle&#34;, &#34;header&#34;)'>
														<!-- Insert Icon -->
													
														Header 
													</div>
													<div class='popover-item btn btn-primary btn-xsm' onclick='add_rect(&#34;rectangle&#34;, &#34;body&#34;)'>
													
														Body 
													</div>
													<div class='popover-item btn btn-primary btn-xsm' onclick='add_rect(&#34;rectangle&#34;, &#34;footer&#34;)'>
													
														Footer 
													</div>
					</div>
													
												
												</div>
											">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="4" fill="currentColor" />
                                <rect x="11" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                                <rect x="15" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                                <rect x="7" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                            </svg>
                        </span>

                    </div>
                    <div class="circle"> <span class="svg-icon svg-icon-gray-800 svg-icon-2hx shape-action"
                            data-placement="bottom" data-toggle="popover" data-html="true" data-content="
											<div class='popover-header'>header</div>
												<div class='popover-body w-175px p-0'>
												<span class='svg-icon svg-icon-muted svg-icon-2hx'><svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
								<path opacity='0.3' d='M22 5V19C22 19.6 21.6 20 21 20H19.5L11.9 12.4C11.5 12 10.9 12 10.5 12.4L3 20C2.5 20 2 19.5 2 19V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5ZM7.5 7C6.7 7 6 7.7 6 8.5C6 9.3 6.7 10 7.5 10C8.3 10 9 9.3 9 8.5C9 7.7 8.3 7 7.5 7Z' fill='currentColor'/>
								<path d='M19.1 10C18.7 9.60001 18.1 9.60001 17.7 10L10.7 17H2V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V12.9L19.1 10Z' fill='currentColor'/>
								</svg>
								</span>
													Insert into 
													<div class='d-flex gap-1'>
													<div class='popover-item btn btn-primary btn-xsm' onclick='add_rect(&#34;circle&#34;, &#34;header&#34;)'>
														<!-- Insert Icon -->
													
														Header 
													</div>
													<div class='popover-item btn btn-primary btn-xsm' onclick='add_rect(&#34;circle&#34;, &#34;body&#34;)'>
													
														Body 
													</div>
													<div class='popover-item btn btn-primary btn-xsm' onclick='add_rect(&#34;circle&#34;,  &#34;footer&#34;)'>
													
														Footer 
													</div>
					</div>
													
												
												</div>
											">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="4" fill="currentColor" />
                                <rect x="11" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                                <rect x="15" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                                <rect x="7" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                            </svg>
                        </span></div>
                    <div class="triangle-up"><span class="svg-icon svg-icon-gray-800 svg-icon-2hx shape-action"
                            data-placement="bottom" data-toggle="popover" data-html="true" data-content="
											<div class='popover-header'>header</div>
												<div class='popover-body w-175px p-0'>
												<span class='svg-icon svg-icon-muted svg-icon-2hx'><svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
								<path opacity='0.3' d='M22 5V19C22 19.6 21.6 20 21 20H19.5L11.9 12.4C11.5 12 10.9 12 10.5 12.4L3 20C2.5 20 2 19.5 2 19V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5ZM7.5 7C6.7 7 6 7.7 6 8.5C6 9.3 6.7 10 7.5 10C8.3 10 9 9.3 9 8.5C9 7.7 8.3 7 7.5 7Z' fill='currentColor'/>
								<path d='M19.1 10C18.7 9.60001 18.1 9.60001 17.7 10L10.7 17H2V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V12.9L19.1 10Z' fill='currentColor'/>
								</svg>
								</span>
													Insert into 
													<div class='d-flex gap-1'>
													<div class='popover-item btn btn-primary btn-xsm' onclick='add_rect(&#34;triangle-up&#34;, &#34;header&#34;)'>
														<!-- Insert Icon -->
													
														Header 
													</div>
													<div class='popover-item btn btn-primary btn-xsm' onclick='add_rect(&#34;triangle-up&#34;, &#34;body&#34;)'>
													
														Body 
													</div>
													<div class='popover-item btn btn-primary btn-xsm' onclick='add_rect(&#34;triangle-up&#34;,  &#34;footer&#34;)'>
													
														Footer 
													</div>
					</div>
													
												
												</div>
											">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="4" fill="currentColor" />
                                <rect x="11" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                                <rect x="15" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                                <rect x="7" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                            </svg>
                        </span></div>
                    <div class="triangle-down"><span class="svg-icon svg-icon-gray-800 svg-icon-2hx shape-action"
                            data-placement="bottom" data-toggle="popover" data-html="true" data-content="
											<div class='popover-header'>header</div>
												<div class='popover-body w-175px p-0'>
												<span class='svg-icon svg-icon-muted svg-icon-2hx'><svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
								<path opacity='0.3' d='M22 5V19C22 19.6 21.6 20 21 20H19.5L11.9 12.4C11.5 12 10.9 12 10.5 12.4L3 20C2.5 20 2 19.5 2 19V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5ZM7.5 7C6.7 7 6 7.7 6 8.5C6 9.3 6.7 10 7.5 10C8.3 10 9 9.3 9 8.5C9 7.7 8.3 7 7.5 7Z' fill='currentColor'/>
								<path d='M19.1 10C18.7 9.60001 18.1 9.60001 17.7 10L10.7 17H2V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V12.9L19.1 10Z' fill='currentColor'/>
								</svg>
								</span>
													Insert into 
													<div class='d-flex gap-1'>
													<div class='popover-item btn btn-primary btn-xsm' onclick='add_rect(&#34;triangle-down&#34;, &#34;header&#34;)'>
														<!-- Insert Icon -->
													
														Header 
													</div>
													<div class='popover-item btn btn-primary btn-xsm' onclick='add_rect(&#34;triangle-down&#34;, &#34;body&#34;)'>
													
														Body 
													</div>
													<div class='popover-item btn btn-primary btn-xsm' onclick='add_rect(&#34;triangle-down&#34;,  &#34;footer&#34;)'>
													
														Footer 
													</div>
					</div>
													
												
												</div>
											">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="4" fill="currentColor" />
                                <rect x="11" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                                <rect x="15" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                                <rect x="7" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                            </svg>
                        </span></div>
                </div>


                <div class="d-flex gap-1 my-3 mx-2 mt-12 ">
                    <div class="opacity-15  start-0 border-4 border-dark border-bottom w-25"></div>

                    <div class=" opacity-15  start-0 border-4 border-dotted border-dark border-bottom w-25"></div>

                    <div class=" opacity-15  start-0 border-4 border-double border-dark border-bottom w-25"></div>
                </div>
                <div class="d-flex gap-1 my-3 mx-2">
                    <div class="w-25">
                        <span class="svg-icon svg-icon-gray-800 svg-icon-2hx " data-placement="bottom"
                            data-toggle="popover" data-html="true" data-content="
											<div class='popover-header'>Solid Line</div>
												<div class='popover-body w-175px p-0'>
												<span class='svg-icon svg-icon-muted svg-icon-2hx'><svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
								<path opacity='0.3' d='M22 5V19C22 19.6 21.6 20 21 20H19.5L11.9 12.4C11.5 12 10.9 12 10.5 12.4L3 20C2.5 20 2 19.5 2 19V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5ZM7.5 7C6.7 7 6 7.7 6 8.5C6 9.3 6.7 10 7.5 10C8.3 10 9 9.3 9 8.5C9 7.7 8.3 7 7.5 7Z' fill='currentColor'/>
								<path d='M19.1 10C18.7 9.60001 18.1 9.60001 17.7 10L10.7 17H2V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V12.9L19.1 10Z' fill='currentColor'/>
								</svg>
								</span>
													Insert into 
													<div class='d-flex gap-1'>
													<div class='popover-item btn btn-primary btn-xsm' onclick='add_line(&#34;solid&#34;, &#34;header&#34;)'>
														<!-- Insert Icon -->
													
														Header 
													</div>
													<div class='popover-item btn btn-primary btn-xsm' onclick='add_line(&#34;solid&#34;, &#34;body&#34;)'>
													
														Body 
													</div>
													<div class='popover-item btn btn-primary btn-xsm' onclick='add_line(&#34;solid&#34;,  &#34;footer&#34;)'>
													
														Footer 
													</div>
								</div>
													
												
												</div>
											">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="4" fill="currentColor" />
                                <rect x="11" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                                <rect x="15" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                                <rect x="7" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                            </svg>
                        </span>
                    </div>
                    <div class="w-25">
                        <span class="svg-icon svg-icon-gray-800 svg-icon-2hx " data-placement="bottom"
                            data-toggle="popover" data-html="true" data-content="
											<div class='popover-header'>Dotted Line</div>
												<div class='popover-body w-175px p-0'>
												<span class='svg-icon svg-icon-muted svg-icon-2hx'><svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
								<path opacity='0.3' d='M22 5V19C22 19.6 21.6 20 21 20H19.5L11.9 12.4C11.5 12 10.9 12 10.5 12.4L3 20C2.5 20 2 19.5 2 19V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5ZM7.5 7C6.7 7 6 7.7 6 8.5C6 9.3 6.7 10 7.5 10C8.3 10 9 9.3 9 8.5C9 7.7 8.3 7 7.5 7Z' fill='currentColor'/>
								<path d='M19.1 10C18.7 9.60001 18.1 9.60001 17.7 10L10.7 17H2V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V12.9L19.1 10Z' fill='currentColor'/>
								</svg>
								</span>
													Insert into 
													<div class='d-flex gap-1'>
													<div class='popover-item btn btn-primary btn-xsm' onclick='add_line(&#34;dotted&#34;, &#34;header&#34;)'>
														<!-- Insert Icon -->
													
														Header 
													</div>
													<div class='popover-item btn btn-primary btn-xsm' onclick='add_line(&#34;dotted&#34;, &#34;body&#34;)'>
													
														Body 
													</div>
													<div class='popover-item btn btn-primary btn-xsm' onclick='add_line(&#34;dotted&#34;,  &#34;footer&#34;)'>
													
														Footer 
													</div>
								</div>
													
												
												</div>
											">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="4" fill="currentColor" />
                                <rect x="11" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                                <rect x="15" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                                <rect x="7" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                            </svg>
                        </span>
                    </div>
                    <div class="w-25">
                        <span class="svg-icon svg-icon-gray-800 svg-icon-2hx " data-placement="bottom"
                            data-toggle="popover" data-html="true" data-content="
											<div class='popover-header'>Double Line</div>
												<div class='popover-body w-175px p-0'>
												<span class='svg-icon svg-icon-muted svg-icon-2hx'><svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
								<path opacity='0.3' d='M22 5V19C22 19.6 21.6 20 21 20H19.5L11.9 12.4C11.5 12 10.9 12 10.5 12.4L3 20C2.5 20 2 19.5 2 19V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5ZM7.5 7C6.7 7 6 7.7 6 8.5C6 9.3 6.7 10 7.5 10C8.3 10 9 9.3 9 8.5C9 7.7 8.3 7 7.5 7Z' fill='currentColor'/>
								<path d='M19.1 10C18.7 9.60001 18.1 9.60001 17.7 10L10.7 17H2V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V12.9L19.1 10Z' fill='currentColor'/>
								</svg>
								</span>
													Insert into 
													<div class='d-flex gap-1'>
													<div class='popover-item btn btn-primary btn-xsm' onclick='add_line(&#34;double&#34;, &#34;header&#34;)'>
														<!-- Insert Icon -->
													
														Header 
													</div>
													<div class='popover-item btn btn-primary btn-xsm' onclick='add_line(&#34;double&#34;, &#34;body&#34;)'>
													
														Body 
													</div>
													<div class='popover-item btn btn-primary btn-xsm' onclick='add_line(&#34;double&#34;,  &#34;footer&#34;)'>
													
														Footer 
													</div>
								</div>
													
												
												</div>
											">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="4" fill="currentColor" />
                                <rect x="11" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                                <rect x="15" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                                <rect x="7" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                            </svg>
                        </span>
                    </div>
                </div>
            </div>
        </div>



        <div class="card card-docs flex-row-fluid mb-2 w-25 menu-card d-none" id="upload_images">
            <div class="card-header border-0 m-0 p-0 w-100">
                <div class="hidden-print w-100">
                    <div class="d-flex align-items-center  py-5 m-0 p-0 bg-light-info  ">
                        <!--begin::Icon-->
                        <div class="d-flex h-80px w-80px flex-shrink-0 flex-center position-relative ms-3 me-6">
                            <!--begin::Svg Icon | path: icons/duotune/abstract/abs051.svg-->
                            <span class="svg-icon svg-icon-info position-absolute opacity-10">
                                <svg class=". w-80px h-80px ." xmlns="http://www.w3.org/2000/svg" width="70px"
                                    height="70px" viewBox="0 0 70 70" fill="none">
                                    <path
                                        d="M28 4.04145C32.3316 1.54059 37.6684 1.54059 42 4.04145L58.3109 13.4585C62.6425 15.9594 65.3109 20.5812 65.3109 25.5829V44.4171C65.3109 49.4188 62.6425 54.0406 58.3109 56.5415L42 65.9585C37.6684 68.4594 32.3316 68.4594 28 65.9585L11.6891 56.5415C7.3575 54.0406 4.68911 49.4188 4.68911 44.4171V25.5829C4.68911 20.5812 7.3575 15.9594 11.6891 13.4585L28 4.04145Z"
                                        fill="currentColor"></path>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--begin::Svg Icon | path: icons/duotune/art/art006.svg-->
                            <span class="svg-icon svg-icon-3x svg-icon-info position-absolute">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3" d="M5 8.04999L11.8 11.95V19.85L5 15.85V8.04999Z"
                                        fill="currentColor" />
                                    <path
                                        d="M20.1 6.65L12.3 2.15C12 1.95 11.6 1.95 11.3 2.15L3.5 6.65C3.2 6.85 3 7.15 3 7.45V16.45C3 16.75 3.2 17.15 3.5 17.25L11.3 21.75C11.5 21.85 11.6 21.85 11.8 21.85C12 21.85 12.1 21.85 12.3 21.75L20.1 17.25C20.4 17.05 20.6 16.75 20.6 16.45V7.45C20.6 7.15 20.4 6.75 20.1 6.65ZM5 15.85V7.95L11.8 4.05L18.6 7.95L11.8 11.95V19.85L5 15.85Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Icon-->
                        <!--begin::Description-->


                        <div class="kt-primary fw-bold fs-3 lh-lg">
                            Upload Images
                            <div class=" fs-6 fw-normal">drag and drop the element in workspace area </div>

                        </div>
                        <!--end::Description-->
                    </div>
                </div>
            </div>
            <div class="card-body fs-6 p-2  text-gray-700" id="img-list">

                <div class="row bg-black" id="gallery_container">

                    <?php 
					$pop_place='left';
					foreach($gallery_images as $img ): 
						$pop_place = ($pop_place == 'right') ? 'auto' : 'auto';
					?>
                    <div class="col-md-6" id="img_cont_<?= $img['file_id']; ?>">
                        <span class="svg-icon svg-icon-gray-800 svg-icon-2hx image-action"
                            data-placement="<?= $pop_place; ?>" data-toggle="popover" data-html="true" data-content="
											<div class='popover-header'>header</div>
												<div class='popover-body w-175px p-0'>
												<span class='svg-icon svg-icon-muted svg-icon-2hx'><svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
								<path opacity='0.3' d='M22 5V19C22 19.6 21.6 20 21 20H19.5L11.9 12.4C11.5 12 10.9 12 10.5 12.4L3 20C2.5 20 2 19.5 2 19V5C2 4.4 2.4 4 3 4H21C21.6 4 22 4.4 22 5ZM7.5 7C6.7 7 6 7.7 6 8.5C6 9.3 6.7 10 7.5 10C8.3 10 9 9.3 9 8.5C9 7.7 8.3 7 7.5 7Z' fill='currentColor'/>
								<path d='M19.1 10C18.7 9.60001 18.1 9.60001 17.7 10L10.7 17H2V19C2 19.6 2.4 20 3 20H21C21.6 20 22 19.6 22 19V12.9L19.1 10Z' fill='currentColor'/>
								</svg>
								</span>
													Insert into 
													<div class='d-flex gap-1'>
													<div class='popover-item btn btn-primary btn-xsm' onclick='insert_img(&#34;<?= cacheable_app_file_url($img['file_id']); ?>&#34;, &#34;<?= $img['file_id']; ?>&#34;, &#34;header&#34;)'>
														<!-- Insert Icon -->
													
														Header 
													</div>
													<div class='popover-item btn btn-primary btn-xsm' onclick='insert_img(&#34;<?= cacheable_app_file_url($img['file_id']); ?>&#34;, &#34;<?= $img['file_id']; ?>&#34; , &#34;body&#34;)'>
													
														Body 
													</div>
													<div class='popover-item btn btn-primary btn-xsm' onclick='insert_img(&#34;<?= cacheable_app_file_url($img['file_id']); ?>&#34;, &#34;<?= $img['file_id']; ?>&#34; , &#34;footer&#34;)'>
													
														Footer 
													</div>
					</div>
													<div class='popover-item '  onclick='set_bg(&#34;<?= cacheable_app_file_url($img['file_id']); ?>&#34;, &#34;<?= $img['file_id']; ?>&#34;)'>
														<!-- Set as Background Icon -->
														<span class='svg-icon svg-icon-muted svg-icon-2hx'><svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
								<rect opacity='0.3' x='2' y='2' width='20' height='20' rx='10' fill='currentColor'/>
								<path d='M15.8054 11.639C15.6757 11.5093 15.5184 11.4445 15.3331 11.4445H15.111V10.1111C15.111 9.25927 14.8055 8.52784 14.1944 7.91672C13.5833 7.30557 12.8519 7 12 7C11.148 7 10.4165 7.30557 9.80547 7.9167C9.19432 8.52784 8.88885 9.25924 8.88885 10.1111V11.4445H8.66665C8.48153 11.4445 8.32408 11.5093 8.19444 11.639C8.0648 11.7685 8 11.926 8 12.1112V16.1113C8 16.2964 8.06482 16.4539 8.19444 16.5835C8.32408 16.7131 8.48153 16.7779 8.66665 16.7779H15.3333C15.5185 16.7779 15.6759 16.7131 15.8056 16.5835C15.9351 16.4539 16 16.2964 16 16.1113V12.1112C16.0001 11.926 15.9351 11.7686 15.8054 11.639ZM13.7777 11.4445H10.2222V10.1111C10.2222 9.6204 10.3958 9.20138 10.7431 8.85421C11.0903 8.507 11.5093 8.33343 12 8.33343C12.4909 8.33343 12.9097 8.50697 13.257 8.85421C13.6041 9.20135 13.7777 9.6204 13.7777 10.1111V11.4445Z' fill='currentColor'/>
								</svg>
								</span>
														Set as Background
													</div>
													<div class='popover-item' onclick='delete_img(<?= $img['file_id']; ?>)'>
														<!-- Delete Icon -->
														<span class='svg-icon svg-icon-muted svg-icon-2hx'><svg width='22' height='22' viewBox='0 0 22 22' fill='none' xmlns='http://www.w3.org/2000/svg'>
								<path opacity='0.3' d='M19.5997 3.52344H2.39639C2.09618 3.53047 1.8003 3.59658 1.52565 3.718C1.25101 3.83941 1.00298 4.01375 0.79573 4.23106C0.588484 4.44837 0.426087 4.70438 0.317815 4.98447C0.209544 5.26456 0.157521 5.56324 0.164719 5.86344C0.157521 6.16364 0.209544 6.46232 0.317815 6.74241C0.426087 7.0225 0.588484 7.27851 0.79573 7.49581C1.00298 7.71312 1.25101 7.88746 1.52565 8.00888C1.8003 8.1303 2.09618 8.19641 2.39639 8.20344H19.5997C19.8999 8.19641 20.1958 8.1303 20.4704 8.00888C20.7451 7.88746 20.9931 7.71312 21.2004 7.49581C21.4076 7.27851 21.57 7.0225 21.6783 6.74241C21.7866 6.46232 21.8386 6.16364 21.8314 5.86344C21.8386 5.56324 21.7866 5.26456 21.6783 4.98447C21.57 4.70438 21.4076 4.44837 21.2004 4.23106C20.9931 4.01375 20.7451 3.83941 20.4704 3.718C20.1958 3.59658 19.8999 3.53047 19.5997 3.52344Z' fill='currentColor' fill-opacity='0.8'/>
								<path d='M2.39453 8.20361L4.01953 18.3111C4.15644 19.145 4.58173 19.9043 5.22121 20.4567C5.8607 21.009 6.6738 21.3194 7.5187 21.3336H14.5712C15.4215 21.3202 16.2395 21.006 16.8801 20.4468C17.5207 19.8875 17.9424 19.1193 18.0704 18.2786L19.5979 8.20361H2.39453ZM9.28453 16.3178C9.28453 16.5333 9.19893 16.7399 9.04656 16.8923C8.89418 17.0447 8.68752 17.1303 8.47203 17.1303C8.25654 17.1303 8.04988 17.0447 7.89751 16.8923C7.74513 16.7399 7.65953 16.5333 7.65953 16.3178V12.4069C7.65953 12.1915 7.74513 11.9848 7.89751 11.8324C8.04988 11.68 8.25654 11.5944 8.47203 11.5944C8.68752 11.5944 8.89418 11.68 9.04656 11.8324C9.19893 11.9848 9.28453 12.1915 9.28453 12.4069V16.3178ZM14.322 16.3178C14.322 16.5333 14.2364 16.7399 14.0841 16.8923C13.9317 17.0447 13.725 17.1303 13.5095 17.1303C13.294 17.1303 13.0874 17.0447 12.935 16.8923C12.7826 16.7399 12.697 16.5333 12.697 16.3178V12.4069C12.697 12.1915 12.7826 11.9848 12.935 11.8324C13.0874 11.68 13.294 11.5944 13.5095 11.5944C13.725 11.5944 13.9317 11.68 14.0841 11.8324C14.2364 11.9848 14.322 12.1915 14.322 12.4069V16.3178Z' fill='currentColor' fill-opacity='0.8'/>
								<path d='M17.3895 4.87755C17.2529 4.87776 17.1185 4.84303 16.999 4.77667C16.8796 4.71031 16.7791 4.61452 16.707 4.49839L14.5945 1.24839C14.488 1.07063 14.4544 0.858502 14.5009 0.656521C14.5473 0.45454 14.6702 0.2784 14.8437 0.165055C15.0215 0.0626479 15.2311 0.0303209 15.4315 0.0744071C15.6319 0.118493 15.8086 0.235816 15.927 0.403388L18.0395 3.70755C18.1434 3.88599 18.1755 4.09728 18.1292 4.2985C18.0829 4.49972 17.9618 4.67577 17.7904 4.79089C17.6659 4.85225 17.5282 4.88202 17.3895 4.87755Z' fill='currentColor' fill-opacity='0.8'/>
								<path d='M4.49988 4.8885C4.34679 4.8928 4.19591 4.85131 4.06655 4.76933C3.89514 4.65422 3.77399 4.47817 3.72771 4.27694C3.68143 4.07572 3.71349 3.86443 3.81738 3.686L5.98405 0.435999C6.09739 0.262485 6.27353 0.13961 6.47551 0.0931545C6.6775 0.0466989 6.88962 0.0802727 7.06738 0.186832C7.23676 0.303623 7.35627 0.479597 7.40239 0.680101C7.4485 0.880606 7.41788 1.09111 7.31655 1.27017L5.20405 4.52017C5.12881 4.63747 5.0243 4.73313 4.90082 4.79773C4.77733 4.86232 4.63914 4.8936 4.49988 4.8885Z' fill='currentColor' fill-opacity='0.8'/>
								</svg>
								</span>
														Delete
													</div>
												</div>
											">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="4" fill="currentColor" />
                                <rect x="11" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                                <rect x="15" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                                <rect x="7" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                            </svg>
                        </span>
                        <div class="d-flex flex-center h-200px">
                            <img src="<?= cacheable_app_file_url($img['file_id']); ?>"
                                class="lozad rounded mw-100 gallery-image" alt="" />
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

            </div>
            <button type="button" class="btn btn-primary sticky-button " id="dropzoneUpload">
                <span class="svg-icon svg-icon-muted svg-icon-2hx"><svg width="24" height="24" viewBox="0 0 24 24"
                        fill="none" xmlns="http://www.w3.org/2000/svg">
                        <rect opacity="0.3" x="12.75" y="4.25" width="12" height="2" rx="1"
                            transform="rotate(90 12.75 4.25)" fill="currentColor" />
                        <path
                            d="M12.0573 6.11875L13.5203 7.87435C13.9121 8.34457 14.6232 8.37683 15.056 7.94401C15.4457 7.5543 15.4641 6.92836 15.0979 6.51643L12.4974 3.59084C12.0996 3.14332 11.4004 3.14332 11.0026 3.59084L8.40206 6.51643C8.0359 6.92836 8.0543 7.5543 8.44401 7.94401C8.87683 8.37683 9.58785 8.34458 9.9797 7.87435L11.4427 6.11875C11.6026 5.92684 11.8974 5.92684 12.0573 6.11875Z"
                            fill="currentColor" />
                        <path opacity="0.3"
                            d="M18.75 8.25H17.75C17.1977 8.25 16.75 8.69772 16.75 9.25C16.75 9.80228 17.1977 10.25 17.75 10.25C18.3023 10.25 18.75 10.6977 18.75 11.25V18.25C18.75 18.8023 18.3023 19.25 17.75 19.25H5.75C5.19772 19.25 4.75 18.8023 4.75 18.25V11.25C4.75 10.6977 5.19771 10.25 5.75 10.25C6.30229 10.25 6.75 9.80228 6.75 9.25C6.75 8.69772 6.30229 8.25 5.75 8.25H4.75C3.64543 8.25 2.75 9.14543 2.75 10.25V19.25C2.75 20.3546 3.64543 21.25 4.75 21.25H18.75C19.8546 21.25 20.75 20.3546 20.75 19.25V10.25C20.75 9.14543 19.8546 8.25 18.75 8.25Z"
                            fill="currentColor" />
                    </svg>
                </span>
                Upload an Image
            </button>
        </div>
        <div class="card card-docs flex-row-fluid mb-2 w-25 menu-card " id="setup">
            <div class="card-header border-0 m-0 p-0 w-100">
                <div class="hidden-print w-100">
                    <div class="d-flex align-items-center  py-5 m-0 p-0 bg-light-info  ">
                        <!--begin::Icon-->
                        <div class="d-flex h-80px w-80px flex-shrink-0 flex-center position-relative ms-3 me-6">
                            <!--begin::Svg Icon | path: icons/duotune/abstract/abs051.svg-->
                            <span class="svg-icon svg-icon-info position-absolute opacity-10">
                                <svg class=". w-80px h-80px ." xmlns="http://www.w3.org/2000/svg" width="70px"
                                    height="70px" viewBox="0 0 70 70" fill="none">
                                    <path
                                        d="M28 4.04145C32.3316 1.54059 37.6684 1.54059 42 4.04145L58.3109 13.4585C62.6425 15.9594 65.3109 20.5812 65.3109 25.5829V44.4171C65.3109 49.4188 62.6425 54.0406 58.3109 56.5415L42 65.9585C37.6684 68.4594 32.3316 68.4594 28 65.9585L11.6891 56.5415C7.3575 54.0406 4.68911 49.4188 4.68911 44.4171V25.5829C4.68911 20.5812 7.3575 15.9594 11.6891 13.4585L28 4.04145Z"
                                        fill="currentColor"></path>
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                            <!--begin::Svg Icon | path: icons/duotune/art/art006.svg-->
                            <span class="svg-icon svg-icon-3x svg-icon-info position-absolute">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.3" d="M5 8.04999L11.8 11.95V19.85L5 15.85V8.04999Z"
                                        fill="currentColor" />
                                    <path
                                        d="M20.1 6.65L12.3 2.15C12 1.95 11.6 1.95 11.3 2.15L3.5 6.65C3.2 6.85 3 7.15 3 7.45V16.45C3 16.75 3.2 17.15 3.5 17.25L11.3 21.75C11.5 21.85 11.6 21.85 11.8 21.85C12 21.85 12.1 21.85 12.3 21.75L20.1 17.25C20.4 17.05 20.6 16.75 20.6 16.45V7.45C20.6 7.15 20.4 6.75 20.1 6.65ZM5 15.85V7.95L11.8 4.05L18.6 7.95L11.8 11.95V19.85L5 15.85Z"
                                        fill="currentColor" />
                                </svg>
                            </span>
                            <!--end::Svg Icon-->
                        </div>
                        <!--end::Icon-->
                        <!--begin::Description-->


                        <div class="kt-primary fw-bold fs-3 lh-lg">
                            Setup the template
                            <div class=" fs-6 fw-normal">Setup this tempalte then apply changes </div>

                        </div>
                        <!--end::Description-->
                    </div>
                </div>
            </div>
            <div class="card-body fs-6  text-gray-700" style="padding: 0px;">
                <form class="" style="" id="filterForm" method="post"
                    action="<?php echo site_url("Receipt/update_receipt_detail"); ?>" enctype="multipart/form-data">
                    <input type="hidden" name="id" value="<?php echo $receipt['id']; ?>">





                    <div class="px-7 py-5">
                        <!--begin::Input group-->
                        <div class="mb-10 ">
                            <label class="form-label fs-6 fw-semibold">Template Name:</label>
                            <input type="text" value="<?= $receipt['title'] ?>" class="form-control" id="title"
                                name="title">
                        </div>
                        <div class="form-group">
                            <div class="mb-10" data-select2-id="select2-data-200-4jj8">
                                <label class="form-label fs-6 fw-semibold">Template Group:</label>
                                <select id="template_group" class="form-select form-select-solid fw-bold "
                                    data-placeholder="Select option" name="template_group">
                                    <option
                                        <?= ($receipt['template_group'] == 'Recipts and Invoices') ? 'selected' : ''; ?>
                                        value="Recipts and Invoices">Recipts and Invoices
                                    </option>

                                </select>
                            </div>
                        </div>
                        <!--end::Input group-->

                        <div class="row customSizeInputs"
                            style="display: <?= ($receipt['size'] == 'custom') ? 'block' : 'none'; ?>;">
                            <!--begin::Input group-->
                            <div class="mb-10 col-6">
                                <label class="form-label fs-6 fw-semibold">Width:</label>
                                <input type="number" value="<?= $receipt['width'] ?>" class="form-control" id="width"
                                    name="width">
                            </div>
                            <!--end::Input group-->

                            <!--begin::Input group-->
                            <div class="mb-10  col-6">
                                <label class="form-label fs-6 fw-semibold">Height:</label>
                                <input type="number" value="<?= $receipt['height'] ?>" class="form-control" id="height"
                                    name="height">
                            </div>
                            <!--end::Input group-->
                        </div>




                        <div class="row">

                            <div class="mb-10  col-md-6 fv-row">

                                <div class="mb-10" data-select2-id="select2-data-200-4jj8">
                                    <label class="form-label fs-6 fw-semibold">Paper size:</label>
                                    <select id="papersize" class="form-select form-select-solid fw-bold "
                                        data-placeholder="Select option" name="size">
                                        <option <?= ($receipt['size'] == 'A4') ? 'selected' : ''; ?> value="A4">A4
                                        </option>
                                        <option <?= ($receipt['size'] == 'A3') ? 'selected' : ''; ?> value="A3">A3
                                        </option>
                                        <option <?= ($receipt['size'] == 'A5') ? 'selected' : ''; ?> value="A5">A5
                                        </option>
                                        <option <?= ($receipt['size'] == 'Letter') ? 'selected' : ''; ?> value="Letter">
                                            Letter
                                        </option>
                                        <option <?= ($receipt['size'] == 'Legal') ? 'selected' : ''; ?> value="Legal">
                                            Legal
                                        </option>
                                        <option <?= ($receipt['size'] == 'Executive') ? 'selected' : ''; ?>
                                            value="Executive">
                                            Executive</option>
                                        <option <?= ($receipt['size'] == 'B4') ? 'selected' : ''; ?> value="B4">B4
                                        </option>
                                        <option <?= ($receipt['size'] == 'B5') ? 'selected' : ''; ?> value="B5">B5
                                        </option>
                                        <option <?= ($receipt['size'] == 'custom') ? 'selected' : ''; ?> value="custom">
                                            Custom
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="mb-10  col-md-6 fv-row">
                                <div class="form-group">
                                    <div class="mb-10" data-select2-id="select2-data-200-4jj8">
                                        <label class="form-label fs-6 fw-semibold">Status:</label>
                                        <select id="status" class="form-select form-select-solid fw-bold "
                                            data-placeholder="Select option" name="status">
                                            <option <?= ($receipt['status'] == '1') ? 'selected' : ''; ?> value="1">
                                                Draft
                                            </option>
                                            <option <?= ($receipt['status'] == '2') ? 'selected' : ''; ?> value="2">
                                                Published
                                            </option>

                                        </select>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <!--end::Input group-->


                        <?php
								
									if ($receipt['logo_image']) {
										$img_logo_image = cacheable_app_file_url($receipt['logo_image']);
									}
									$img_background_image = '/assets/media/svg/avatars/blank.svg';
									if ($receipt['background_image']) {
										$img_background_image = cacheable_app_file_url($receipt['background_image']);
									}

									?>

                        <input type="hidden" name="background_image_id" id="background_image_id"
                            value="<?php echo $receipt['background_image']; ?>" />
                        <input type="hidden" value="<?= $receipt['header_percentage'] ?>" name="header_percentage"
                            id="header-value-input" />
                        <input type="hidden" value="<?= $receipt['body_percentage'] ?>" name="body_percentage"
                            id="body-value-input" />
                        <input type="hidden" value="<?= $receipt['footer_percentage'] ?>" name="footer_percentage"
                            id="footer-value-input" />
                        <label class="form-label fs-6 fw-semibold">Adjust header , body ,footer size :</label>
                        <div id="percentage-slider" class="mb-5"></div>
                        Header: <span id="header-value">0%</span>
                        Body:<span id="body-value">0%</span>
                        Footer:<span id="footer-value">0%</span>



                        <label class="form-label fs-6 fw-semibold mt-5">Use template as default for:</label>
                        <div class="form-check form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox" value="1" name="default_wo"
                                id="default_work_order" <?= ($receipt['default_wo']) ? 'checked' : ''; ?> />
                            <label class="form-check-label" for="default_work_order">
                                Default work order
                            </label>
                        </div>
                        <div class="form-check form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox"
                                <?= ($receipt['default_pos']) ? 'checked' : ''; ?> value="1" name="default_pos"
                                id="default_pos" />
                            <label class="form-check-label" for="default_pos">
                                Default pos receipt
                            </label>
                        </div>
                        <div class="form-check form-check-custom form-check-solid">
                            <input class="form-check-input" type="checkbox"
                                <?= ($receipt['default_estimate']) ? 'checked' : ''; ?> value="1"
                                name="default_estimate" id="default_est" />
                            <label class="form-check-label" for="default_est">
                                Default for estimate
                            </label>
                        </div>



                        <script>
                        function get_height(style) {
                            var match = style.match(/height:\s*(\d+(\.\d+)?%);/);
                            return match ? parseFloat(match[1]) : 0;
                        }
                        $(document).ready(function() {
                            function updateVisibility() {
                                ['header', 'footer'].forEach(function(section) {
                                    var allPages = $('#' + section + '_all_pages').is(':checked');
                                    var firstPage = $('#' + section + '_first_pages').is(':checked');
                                    var lastPage = $('#' + section + '_last_pages').is(':checked');

                                    $('.page_' + section).each(function() {
                                        var $this = $(this);
                                        var isPageOne = $this.closest('.page-one').length > 0;
                                        var isPageThree = $this.closest('.page-three').length >
                                            0;
                                        var isPageTwo = $this.closest('.page-two').length > 0;
                                        // Determine which checkbox is relevant based on the page
                                        var relevantCheckbox = isPageOne ? firstPage : (
                                            isPageThree ? lastPage : allPages);
                                        $this.find('.already_shown').toggle(relevantCheckbox);
                                        $this.find('.resize  ').toggle(relevantCheckbox);
                                        // $this.find('div').toggle(relevantCheckbox);
                                        // Setting border based on the section and page
                                        setBorder($this, relevantCheckbox, section, isPageOne,
                                            isPageThree, isPageTwo);
                                    });
                                });
                            }

                            function setBorder(element, isVisible, section, isPageOne, isPageThree, isPagetwo) {
                                var borderProperty = (section == 'header') ? 'border-bottom' : 'border-top';
                                var reverseborderProperty = (section == 'header') ? 'border-top' :
                                    'border-bottom';
                                var borderStyle = isVisible ? '2px solid black' : 'none';
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
                                    if (!get_height(checkheigh)) {
                                        if (section == 'header') {

                                            var inputValue = parseFloat($('#header-value-input').val()
                                                .replace('%', ''));
                                            var style = element.siblings('.page_body').attr('style');
                                            var currentHeight = get_height(style);
                                            var newHeight = currentHeight - inputValue;
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
                                if (isPageOne || isPageThree || $('.page_' + section).length === 1) {

                                    element.css(borderProperty, borderStyle);
                                    element.siblings('.page_body').css(reverseborderProperty, borderStyle);
                                } else {
                                    if (isPagetwo) {

                                        element.css(borderProperty, borderStyle);
                                        element.siblings('.page_body').css(reverseborderProperty, borderStyle);
                                    }


                                }
                            }

                            $('.section_checkbox').on('change', updateVisibility);
                            updateVisibility(); // Initial visibility update



                            setTimeout(() => {
                                updateVisibility();
                            }, 3000);
                        });


                        $(document).ready(function() {
                            // Function to update tbody clones
                            function updateTbodyClones() {
                                // Get the current values from inputs
                                var firstPageItems = parseInt($('#first_page_items').val());
                                var otherPageItems = parseInt($('#other_page_items').val());

                                // Ensure the numbers are at least 1
                                firstPageItems = isNaN(firstPageItems) ? 1 : Math.max(firstPageItems, 1);
                                otherPageItems = isNaN(otherPageItems) ? 1 : Math.max(otherPageItems, 1);

                                // Update each 'elementWithBackground' div
                                $('.elementWithBackground').each(function() {
                                    var $div = $(this);
                                    var isPageOne = $div.hasClass('page-one');
                                    var requiredClones = isPageOne ? firstPageItems : otherPageItems;
                                    var $tbody = $div.find('tbody').first();
                                    var existingClones = $div.find('tbody').length;

                                    // Adjust tbody clones based on required count
                                    if (requiredClones > existingClones) {
                                        // Need more clones
                                        for (var i = existingClones; i < requiredClones; i++) {
                                            $tbody.clone().appendTo($tbody.parent());
                                        }
                                    } else {
                                        // Need fewer clones
                                        $div.find('tbody').not(':first').slice(requiredClones - 1)
                                            .remove();
                                    }
                                });
                            }

                            // Bind the input change events to the update function
                            $('#first_page_items, #other_page_items').on('change', function() {
                                updateTbodyClones();
                            });

                            // Initialize the clones at document ready
                            updateTbodyClones();
                        });
                        document.addEventListener("DOMContentLoaded", function() {
                            var percentageSlider = document.getElementById('percentage-slider');
                            var initialHeader = parseInt($('#header-value-input').val(), 10) || 20;
                            var initialBody = parseInt($('#body-value-input').val(), 10) || 60;
                            var initialFooter = parseInt($('#footer-value-input').val(), 10) || 20;
                            var secondHandlePosition = initialHeader + initialBody;
                            noUiSlider.create(percentageSlider, {
                                start: [initialHeader, secondHandlePosition],
                                connect: [true, true, true],
                                range: {
                                    'min': 0,
                                    'max': 100
                                },
                                behaviour: 'drag',
                                padding: 0
                            });

                            percentageSlider.noUiSlider.on('update', function(values, handle) {
                                values = values.map(v => parseFloat(v));

                                let headerPercentage = values[0];
                                let bodyPercentage = values[1] - values[0];
                                let footerPercentage = 100 - values[1];

                                document.getElementById('header-value').textContent = headerPercentage
                                    .toFixed(0) + '%';
                                document.getElementById('body-value').textContent = bodyPercentage
                                    .toFixed(0) + '%';
                                document.getElementById('footer-value').textContent = footerPercentage
                                    .toFixed(0) + '%';
                                document.getElementById('header-value-input').value = headerPercentage
                                    .toFixed(0) + '%';
                                document.getElementById('body-value-input').value = bodyPercentage
                                    .toFixed(0) + '%';
                                document.getElementById('footer-value-input').value = footerPercentage
                                    .toFixed(0) + '%';
                                // Update the heights of the divs based on slider values
                                $('.page_header').css('height', headerPercentage + '%');
                                $('.page_body').css('height', bodyPercentage + '%');
                                $('.page_footer').css('height', footerPercentage + '%');
                            });
                        });
                        $(document).ready(function() {
                            $('#check-total').on('click', function() {
                                // Get the current values of the fields
                                var header = parseInt($('#header-height').val()) || 0;
                                var body = parseInt($('#body-height').val()) || 0;
                                var footer = parseInt($('#footer-height').val()) || 0;

                                var total = header + body + footer;

                                if (total !== 100) {
                                    $('#error-message').text(
                                        'Error: The total must equal 100%. Currently, it is ' +
                                        total + '%.');
                                } else {
                                    $('#error-message').text(
                                        ''); // Clear the error message if the total is correct
                                }
                            });
                        });
                        </script>
                        <!--begin::Actions-->
                        <div class="d-flex justify-content-end">

                            <button type="submit" class="btn btn-primary fw-semibold px-6"
                                data-kt-menu-dismiss="true">Apply</button>
                        </div>
                        <!--end::Actions-->
                </form>
            </div>
        </div>





    </div>
    <div class="card card-docs flex-row-fluid mb-2 w-25 menu-card d-none" id="print_view">
        <div class="card-header border-0 m-0 p-0 w-100">
            <div class="hidden-print w-100">
                <div class="d-flex align-items-center  py-5 m-0 p-0 bg-light-info  ">
                    <!--begin::Icon-->
                    <div class="d-flex h-80px w-80px flex-shrink-0 flex-center position-relative ms-3 me-6">
                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs051.svg-->
                        <span class="svg-icon svg-icon-info position-absolute opacity-10">
                            <svg class=". w-80px h-80px ." xmlns="http://www.w3.org/2000/svg" width="70px" height="70px"
                                viewBox="0 0 70 70" fill="none">
                                <path
                                    d="M28 4.04145C32.3316 1.54059 37.6684 1.54059 42 4.04145L58.3109 13.4585C62.6425 15.9594 65.3109 20.5812 65.3109 25.5829V44.4171C65.3109 49.4188 62.6425 54.0406 58.3109 56.5415L42 65.9585C37.6684 68.4594 32.3316 68.4594 28 65.9585L11.6891 56.5415C7.3575 54.0406 4.68911 49.4188 4.68911 44.4171V25.5829C4.68911 20.5812 7.3575 15.9594 11.6891 13.4585L28 4.04145Z"
                                    fill="currentColor"></path>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <!--begin::Svg Icon | path: icons/duotune/art/art006.svg-->
                        <span class="svg-icon svg-icon-3x svg-icon-info position-absolute">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3" d="M5 8.04999L11.8 11.95V19.85L5 15.85V8.04999Z"
                                    fill="currentColor" />
                                <path
                                    d="M20.1 6.65L12.3 2.15C12 1.95 11.6 1.95 11.3 2.15L3.5 6.65C3.2 6.85 3 7.15 3 7.45V16.45C3 16.75 3.2 17.15 3.5 17.25L11.3 21.75C11.5 21.85 11.6 21.85 11.8 21.85C12 21.85 12.1 21.85 12.3 21.75L20.1 17.25C20.4 17.05 20.6 16.75 20.6 16.45V7.45C20.6 7.15 20.4 6.75 20.1 6.65ZM5 15.85V7.95L11.8 4.05L18.6 7.95L11.8 11.95V19.85L5 15.85Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Icon-->
                    <!--begin::Description-->


                    <div class="kt-primary fw-bold fs-3 lh-lg">
                        Print View
                        <div class=" fs-6 fw-normal">Update values to check preview </div>

                    </div>
                    <!--end::Description-->
                </div>
            </div>
        </div>
        <div class="card-body fs-6  text-gray-700">

            <!--begin::Input group-->
            <div class="row ">
                <div class="  col-md-6 fv-row">
                    <label class="form-label fs-6 fw-semibold">First page items:</label>
                    <input type="number" value="<?= $receipt['first_page_items'] ?>" class="form-control"
                        id="first_page_items" name="first_page_items">
                </div>
                <div class=" col-md-6 fv-row">
                    <label class="form-label fs-6 fw-semibold">Other pages items:</label>
                    <input type="number" value="<?= $receipt['other_page_items'] ?>" class="form-control"
                        id="other_page_items" name="other_page_items">
                </div>
            </div>



            <?php $parts = ['header' ,  'footer']; ?>

            <?php foreach($parts as $part): ?>
            <div class="d-flex my-3">
                <label class="form-label fs-6 fw-semibold mt-4 mx-2"><?= $part; ?>:</label>
                <div class="form-check form-check-custom form-check-solid me-4">
                    <input class="form-check-input h-20px w-20px save_checkbox section_checkbox"
                        <?= (in_array($part.'_all_pages',$checks))?'checked':'';?> type="checkbox"
                        name="<?= $part; ?>_all_pages" value="" id="<?= $part; ?>_all_pages" />
                    <label class="form-check-label" for="<?= $part; ?>_all_pages">
                        All other pages
                    </label>
                </div>
                <div class="form-check form-check-custom form-check-solid me-4">
                    <input class="form-check-input h-20px w-20px save_checkbox section_checkbox" type="checkbox"
                        name="<?= $part; ?>_first_pages" value="" id="<?= $part; ?>_first_pages"
                        <?= (in_array($part.'_first_pages',$checks))?'checked':'';?> />
                    <label class="form-check-label" for="<?= $part; ?>_first_pages">
                        first page
                    </label>
                </div>
                <div class="form-check form-check-custom form-check-solid me-4">
                    <input class="form-check-input h-20px w-20px save_checkbox section_checkbox"
                        <?= (in_array($part.'_last_pages',$checks))?'checked':'';?> type="checkbox"
                        name="<?= $part; ?>_last_pages" value="" id="<?= $part; ?>_last_pages" />
                    <label class="form-check-label" for="<?= $part; ?>_last_pages">
                        last page
                    </label>
                </div>

            </div>

            <?php endforeach; ?>
            <div class="d-flex justify-content-end">

                <button onclick="print_receipt()" class="btn btn-primary fw-semibold px-6"
                    data-kt-menu-dismiss="true">Preview</button>
            </div>
        </div>
    </div>
    <script>
    function insert_img(img, id, section) {
        $img =
            '<div class="resize  ui-draggable ui-draggable-handle ui-resizable" style="position: absolute; width:90.5px;height:24px; text-wrap:nowrap; left:1px; top:1px; " data-left="1px" data-top="1px" data-current_width="90.5" data-current_height="24" id="custom_img_' +
            section + '_' +
            id + '"><img src="' + img +
            '" alt=""><span class="position-absolute top-0 start-0 translate-middle  badge badge-circle badge-danger remove_img">x</span><div class="ui-resizable-handle ui-resizable-e" style="z-index: 90;"></div><div class="ui-resizable-handle ui-resizable-s" style="z-index: 90;"></div><div class="ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se" style="z-index: 90;"></div></div>';
        $('.elementWithBackground').find('.page_' + section).prepend($img);
        $(".resize").draggable({
            revert: "invalid",
            containment: "document", // Limit movement within the specified boundary.
            start: function(event, ui) {
                $(this).draggable('option', 'revert', 'invalid');
                $(this).css({
                    'border': '3px dotted black'
                });
            },
            stop: function(event, ui) {
                $(this).css({
                    'border': 'none'
                });
            }
        }).resizable({
            stop: function(event, ui) {
                $(this).attr('data-current_width', ui.size.width);
                $(this).attr('data-current_height', ui.size.height);
            }
        });

        $('.remove_img').on('click', function() {
            $(this).parent().remove();
        })
    }
    // Event handler for button clicks
    function set_bg(backgroundUrl, id) {
        $(".elementWithBackground  ").css("background-image", "url(" + backgroundUrl + ")");
        $('#background_image_id').val(id);
    }

    function delete_img(id) {
        $('#img_cont_' + id).remove();

        $.ajax({
            type: "POST",
            url: "<?= site_url('home/delete_gallery_image')?>",
            data: {
                id: id
            },
            success: function(data) {

            }
        });
    }
    $(document).ready(function() {

        $('[data-toggle="popover"]').popover(); // Initialize all popovers

        // Stop propagation for the popover trigger
        $('[data-toggle="popover"]').on('click', function(e) {



            e.stopPropagation();

        });

        // Close popover on clicking outside
        $(document).on('click', function(e) {

            if (!$(e.target).is(':checkbox') && !$(e.target).parent().hasClass('custom_label_body')) {
                $('[data-toggle="popover"]').popover('hide');
            }
        });

        // Close popover on clicking inside the popover body
        $('.popover').on('click', '.popover-body', function() {

            if (!$(e.target).is(':checkbox') && !$(this).hasClass('custom_label_body')) {
                $('[data-toggle="popover"]').popover('hide');
            }
        });




    });
    Dropzone.autoDiscover = false;
    Dropzone.options.dropzoneUpload = {
        url: "<?php echo site_url('home/gallery_upload'); ?>",
        autoProcessQueue: true,
        acceptedFiles: "image/*",
        uploadMultiple: true,
        parallelUploads: 100,
        maxFiles: 100,
        addRemoveLinks: true,
        dictRemoveFile: "Remove",
        init: function() {
            myDropzone = this;
            this.on("success", function(file, responseText) {
                $('.dz-image-preview').remove();
                $('#gallery_container').prepend(responseText);
                // window.location.reload();

                $('[data-toggle="popover"]').popover(); // Initialize all popovers

                // Stop propagation for the popover trigger
                $('[data-toggle="popover"]').on('click', function(e) {



                    e.stopPropagation();

                });

                // Close popover on clicking outside
                $(document).on('click', function(e) {

                    if (!$(e.target).is(':checkbox') && !$(e.target).parent().hasClass(
                            'custom_label_body')) {
                        $('[data-toggle="popover"]').popover('hide');
                    }
                });

                // Close popover on clicking inside the popover body
                $('.popover').on('click', '.popover-body', function() {

                    if (!$(e.target).is(':checkbox') && !$(this).hasClass(
                        'custom_label_body')) {
                        $('[data-toggle="popover"]').popover('hide');
                    }
                });
            });
        }
    };
    $('#dropzoneUpload').dropzone();

    // myDropzone.on('sending', function(file, xhr, formData){
    // 	formData.append('work_order_id', work_order_id);
    // });
    </script>
    <!--begin::Card-->

    <div class="card card-docs flex-row-fluid mb-2 w-25  menu-card d-none" id="detail_listing_table">
        <div class="card-header border-0 m-0 p-0 w-100">
            <div class="hidden-print w-100">
                <div class="d-flex align-items-center  py-5 m-0 p-0 bg-light-info  ">
                    <!--begin::Icon-->
                    <div class="d-flex h-80px w-80px flex-shrink-0 flex-center position-relative ms-3 me-6">
                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs051.svg-->
                        <span class="svg-icon svg-icon-info position-absolute opacity-10">
                            <svg class=". w-80px h-80px ." xmlns="http://www.w3.org/2000/svg" width="70px" height="70px"
                                viewBox="0 0 70 70" fill="none">
                                <path
                                    d="M28 4.04145C32.3316 1.54059 37.6684 1.54059 42 4.04145L58.3109 13.4585C62.6425 15.9594 65.3109 20.5812 65.3109 25.5829V44.4171C65.3109 49.4188 62.6425 54.0406 58.3109 56.5415L42 65.9585C37.6684 68.4594 32.3316 68.4594 28 65.9585L11.6891 56.5415C7.3575 54.0406 4.68911 49.4188 4.68911 44.4171V25.5829C4.68911 20.5812 7.3575 15.9594 11.6891 13.4585L28 4.04145Z"
                                    fill="currentColor"></path>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <!--begin::Svg Icon | path: icons/duotune/art/art006.svg-->
                        <span class="svg-icon svg-icon-3x svg-icon-info position-absolute">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3" d="M5 8.04999L11.8 11.95V19.85L5 15.85V8.04999Z"
                                    fill="currentColor" />
                                <path
                                    d="M20.1 6.65L12.3 2.15C12 1.95 11.6 1.95 11.3 2.15L3.5 6.65C3.2 6.85 3 7.15 3 7.45V16.45C3 16.75 3.2 17.15 3.5 17.25L11.3 21.75C11.5 21.85 11.6 21.85 11.8 21.85C12 21.85 12.1 21.85 12.3 21.75L20.1 17.25C20.4 17.05 20.6 16.75 20.6 16.45V7.45C20.6 7.15 20.4 6.75 20.1 6.65ZM5 15.85V7.95L11.8 4.05L18.6 7.95L11.8 11.95V19.85L5 15.85Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Icon-->
                    <!--begin::Description-->


                    <div class="kt-primary fw-bold fs-3 lh-lg">
                        Item listing table configuration
                        <div class=" fs-6 fw-normal">Manage the item table to make it fir with your pre-design template
                        </div>

                    </div>
                    <!--end::Description-->
                </div>
            </div>
        </div>
        <div class="card-body fs-6  text-gray-700">

            <div class="row">
                <div class="form-check form-check-custom form-check-solid form-check-lg">
                    <input class="form-check-input save_checkbox" type="checkbox" value=""
                        <?= (in_array('hide_show_all_headers',$checks))?'checked':'';?> id="hide_show_all_headers"
                        name="hide_show_all_headers" onclick="hide_show_all_headers(this)" />
                    <label class="form-check-label" for="flexCheckDefault">
                        Hide the column header name
                    </label>
                </div>
            </div>
            <div class="row">
                <div class="text-gray-700 fw-semibold fs-8 mt-2 me-2">Sort or check-box for each column data to show in
                    receipt</div>
                <div class="separator separator-silid my-1"></div>
            </div>

            <div class="row " id="myKanban">

                <?php 
			

			$table_elements = [
				[
					'id' => 'table_element_item_img',
					'name' => 'item img',
					'checkbox' => 'checkbox_item_img',
				],
				[
					'id' => 'table_element_item_name',
					'name' => 'item name',
					'checkbox' => 'checkbox_item_name',
				],
				[
					'id' => 'table_element_item_price',
					'name' => 'item price',
					'checkbox' => 'checkbox_item_price',  // Assuming there's a typo in 'pric'
				],
				[
					'id' => 'table_element_item_quantity',
					'name' => 'item quantity',
					'checkbox' => 'checkbox_item_quantity',
				],
				[
					'id' => 'table_element_item_total',
					'name' => 'item total',
					'checkbox' => 'checkbox_item_total',
				],
			];
				foreach($table_elements as $ele):
			 ?>
                <div class="  jkanbanlist items-list d-flex align-items-center my-1 py-3 bg-light  rounded-1"
                    style="position: relative; text-wrap:nowrap; width:100%;" id="<?= $ele['id'] ?>">

                    <div class="d-flex h-25px w-80px flex-shrink-0 flex-center position-relative ms-3 me-6">

                        <!--begin::Svg Icon | path: icons/duotune/art/art006.svg-->
                        <span class="svg-icon svg-icon-2x svg-icon-info position-absolute" title="">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4 6C5.10457 6 6 5.10457 6 4C6 2.89543 5.10457 2 4 2C2.89543 2 2 2.89543 2 4C2 5.10457 2.89543 6 4 6Z"
                                    fill="currentColor"></path>
                                <path opacity="0.3"
                                    d="M14 12C14 13.1 13.1 14 12 14C10.9 14 10 13.1 10 12C10 10.9 10.9 10 12 10C13.1 10 14 10.9 14 12ZM4 10C2.9 10 2 10.9 2 12C2 13.1 2.9 14 4 14C5.1 14 6 13.1 6 12C6 10.9 5.1 10 4 10ZM20 10C18.9 10 18 10.9 18 12C18 13.1 18.9 14 20 14C21.1 14 22 13.1 22 12C22 10.9 21.1 10 20 10ZM12 2C10.9 2 10 2.9 10 4C10 5.1 10.9 6 12 6C13.1 6 14 5.1 14 4C14 2.9 13.1 2 12 2ZM20 2C18.9 2 18 2.9 18 4C18 5.1 18.9 6 20 6C21.1 6 22 5.1 22 4C22 2.9 21.1 2 20 2ZM12 18C10.9 18 10 18.9 10 20C10 21.1 10.9 22 12 22C13.1 22 14 21.1 14 20C14 18.9 13.1 18 12 18ZM4 18C2.9 18 2 18.9 2 20C2 21.1 2.9 22 4 22C5.1 22 6 21.1 6 20C6 18.9 5.1 18 4 18ZM20 18C18.9 18 18 18.9 18 20C18 21.1 18.9 22 20 22C21.1 22 22 21.1 22 20C22 18.9 21.1 18 20 18Z"
                                    fill="currentColor"></path>
                            </svg>
                        </span>
                    </div>


                    <div class="kt-dark fw-bold fs-6 lh-lg  w-75">
                        <?= $ele['name'] ?>
                    </div>

                    <div class="form-check form-check-custom form-check-primary mb-3  form-check-lg">
                        <input <?= (in_array($ele['checkbox'],$checks))?'checked':'';?>
                            class="form-check-input save_checkbox heading_checkbox" type="checkbox" value="1"
                            id="<?= $ele['checkbox'] ?>" onchange="show_hide_item_detail('<?= $ele['checkbox'] ?>')" />
                    </div>

                </div>
                <input type='hidden' id="table_element_order">
                <script>
                $(document).ready(function() {
                    $("#table_element_order").val('<?= $receipt['table_element_order'] ?>');
                    $("#myKanban").sortable({
                        containment: "parent",
                        update: function(event, ui) {
                            // After sorting, update the data-sort attributes
                            updateSortOrder();
                            synchronizeElements();
                        }
                    });

                    $("#myKanban").disableSelection();

                    function updateSortOrder() {
                        var order = [];
                        $("#myKanban .items-list").each(function(index) {
                            var itemId = this.id.replace("table_element_", "");
                            var dataId = 'checkbox_' + itemId + '';
                            order.push({
                                id: dataId,
                                order: index + 1
                            });

                            // Update the data-sort attribute to match the new index (+1 since index is 0-based)
                            $(this).attr("data-sort", index + 1);
                        });
                        var jsonString = JSON.stringify(order);
                        $("#table_element_order").val(jsonString);

                    }

                    function synchronizeElements() {
                        $("#myKanban .items-list").each(function(index) {
                            var itemId = this.id.replace("table_element_",
                            ""); // Get the identifier part
                            var targetElements = $('[data-id="checkbox_' + itemId + '"]');

                            // Move target elements to match the new order
                            targetElements.each(function() {
                                $(this).css('order', index); // Assuming Flexbox or Grid layout
                            });
                        });
                    }

                    function load_sort_order() {

                        $order = $("#table_element_order").val();
                        $order = $order.replace(/&quot;/g, '"');
                        $order = JSON.parse($order);

                        $order.forEach(function(item) {
                            // The ID in the JSON is assumed to match elements within the sortable container
                            var itemId = "table_element_" + item.id.replace("checkbox_", "");
                            var $element = $("#" + itemId);

                            // Append the element to reorder them according to the JSON order
                            $("#myKanban").append($element);
                        });
                        synchronizeElements();
                    }


                    load_sort_order();


					
                    if ('<?= (in_array($ele['checkbox'],$checks))?'checked':'nop';?>' == 'checked') {
						
						
                        $("[data-id='<?php echo $ele['checkbox']; ?>']").show();
                    } else {
                        $("[data-id='<?php echo $ele['checkbox']; ?>']").hide();
                    }


                });
                </script>
                <?php endforeach; ?>
            </div>
            <div class="row">

                <div class="separator separator-silid my-1"></div>
                <div class="kt-dark fw-bold fs-6 lh-lg mt-2">Item sub info</div>
                <div class="text-gray-700 fw-semibold fs-8  me-2">Enable column sub info to hide or show on receipt
                </div>
                <div class="separator separator-silid my-1"></div>
            </div>


            <div class="row ">

                <?php 
			

			$table_sub_elements = [
				[
					'id' => 'table_element_variation_name',
					'name' => 'item variation name',
					'checkbox' => 'checkbox_element_variation_name',
				],
				[
					'id' => 'table_element_description',
					'name' => 'item description',
					'checkbox' => 'checkbox_element_description',  
				],
				[
					'id' => 'table_element_serialnumber',
					'name' => 'item serialnumber',
					'checkbox' => 'checkbox_element_item_serialnumber',
				],
				[
					'id' => 'table_element_custom_fields_to_display',
					'name' => 'item custom fields to display',
					'checkbox' => 'checkbox_custom_fields_to_display',
				],[
					'id' => 'table_element_item_kit_info_name',
					'name' => 'item kit info name',
					'checkbox' => 'checkbox_element_item_kit_info_name',
				],[
					'id' => 'table_element_item_kit_custom_fields_to_display',
					'name' => 'item kit custom fields to display',
					'checkbox' => 'checkbox_element_item_kit_custom_fields_to_display',
				],[
					'id' => 'table_element_discount',
					'name' => 'item discount',
					'checkbox' => 'checkbox_element_discount',
				],
                [
					'id' => 'table_element_image',
					'name' => 'item image',
					'checkbox' => 'checkbox_element_image',
				],
			];
				foreach($table_sub_elements as $ele):
			 ?>
                <div class="   items-list d-flex align-items-center my-1 py-3 bg-light  rounded-1"
                    style="position: relative; text-wrap:nowrap; width:100%;" id="<?= $ele['id'] ?>">




                    <div class="kt-dark fw-bold fs-6 lh-lg  w-75">
                        <?= $ele['name'] ?>
                    </div>

                    <div class="form-check form-check-custom form-check-primary mb-3  form-check-lg">
                        <input <?= (in_array($ele['checkbox'],$checks))?'checked':'';?>
                            class="form-check-input save_checkbox" type="checkbox" value="" id="<?= $ele['checkbox'] ?>"
                            onchange="show_hide_item_detail('<?= $ele['checkbox'] ?>')" />
                    </div>

                </div>

                <script>
                $(document).ready(function() {

                    if ('<?= (in_array($ele['checkbox'],$checks))?'checked':'nop';?>' == 'checked') {
                        $("[data-id='<?php echo $ele['checkbox']; ?>']").show();
                    } else {
                        $("[data-id='<?php echo $ele['checkbox']; ?>']").hide();
                    }


                });
                </script>
                <?php endforeach; ?>

            </div>


        </div>
    </div>
    <script>
    $(document).ready(function() {

        if ('<?= (in_array('hide_show_all_headers',$checks))?'checked':'nop';?>' == 'checked') {
            $("[data-id='hide_show_all_headers']").hide();
        } else {
            $("[data-id='hide_show_all_headers']").show();
        }


    });
    </script>

    <div class="card card-docs flex-row-fluid mb-2 w-25  menu-card d-none" id="lables">
        <div class="card-header border-0 m-0 p-0 w-100">
            <div class="hidden-print w-100">
                <div class="d-flex align-items-center  py-5 m-0 p-0 bg-light-info  ">
                    <!--begin::Icon-->
                    <div class="d-flex h-80px w-80px flex-shrink-0 flex-center position-relative ms-3 me-6">
                        <!--begin::Svg Icon | path: icons/duotune/abstract/abs051.svg-->
                        <span class="svg-icon svg-icon-info position-absolute opacity-10">
                            <svg class=". w-80px h-80px ." xmlns="http://www.w3.org/2000/svg" width="70px" height="70px"
                                viewBox="0 0 70 70" fill="none">
                                <path
                                    d="M28 4.04145C32.3316 1.54059 37.6684 1.54059 42 4.04145L58.3109 13.4585C62.6425 15.9594 65.3109 20.5812 65.3109 25.5829V44.4171C65.3109 49.4188 62.6425 54.0406 58.3109 56.5415L42 65.9585C37.6684 68.4594 32.3316 68.4594 28 65.9585L11.6891 56.5415C7.3575 54.0406 4.68911 49.4188 4.68911 44.4171V25.5829C4.68911 20.5812 7.3575 15.9594 11.6891 13.4585L28 4.04145Z"
                                    fill="currentColor"></path>
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                        <!--begin::Svg Icon | path: icons/duotune/art/art006.svg-->
                        <span class="svg-icon svg-icon-3x svg-icon-info position-absolute">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3" d="M5 8.04999L11.8 11.95V19.85L5 15.85V8.04999Z"
                                    fill="currentColor" />
                                <path
                                    d="M20.1 6.65L12.3 2.15C12 1.95 11.6 1.95 11.3 2.15L3.5 6.65C3.2 6.85 3 7.15 3 7.45V16.45C3 16.75 3.2 17.15 3.5 17.25L11.3 21.75C11.5 21.85 11.6 21.85 11.8 21.85C12 21.85 12.1 21.85 12.3 21.75L20.1 17.25C20.4 17.05 20.6 16.75 20.6 16.45V7.45C20.6 7.15 20.4 6.75 20.1 6.65ZM5 15.85V7.95L11.8 4.05L18.6 7.95L11.8 11.95V19.85L5 15.85Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                        <!--end::Svg Icon-->
                    </div>
                    <!--end::Icon-->
                    <!--begin::Description-->


                    <div class="kt-primary fw-bold fs-3 lh-lg">
                        Listing Labels
                        <div class=" fs-6 fw-normal">drag and drop the element in workspace area </div>

                    </div>
                    <!--end::Description-->
                </div>
            </div>
        </div>
        <div class="card-body fs-6  text-gray-700">
            <div class="row">
                <div class="  items-list d-flex align-items-center my-1 py-3 bg-light  rounded-1"
                    style="position: relative; text-wrap:nowrap; width:100%;" id="items_list">
                    <div class="kt-dark fw-bold fs-6 lh-lg  w-75">
                        Custom Label
                    </div>
                    <div class="d-flex h-25px w-80px flex-shrink-0 flex-center position-relative ms-3 me-6">

                        <!--begin::Svg Icon | path: icons/duotune/art/art006.svg-->
                        <span class="svg-icon svg-icon-2x svg-icon-info position-absolute" data-placement="bottom"
                            data-toggle="popover" data-html="true" data-content="
									<div class='popover-header custom_label_body'>Add custom Label</div>
										<div class='popover-body w-150px p-0 custom_label_body'>
											<div class='row p-2 custom_label_body'> 
										<input type='text' id='custom_label_id' class='form-control form-control-solid mt-6' placeholder='label name'/>
										</div>
										<div class='d-flex justify-content-center gap-1 custom_label_body'> 
										<button class='btn btn-icon btn-danger custom_label_body' onclick='close_popover()'><span class='svg-icon svg-icon-muted svg-icon-2hx'><svg width='32' height='32' viewBox='0 0 32 32' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                                <rect x='9.39844' y='20.7144' width='16' height='2.66667' rx='1.33333' transform='rotate(-45 9.39844 20.7144)' fill='currentColor'/>
                                                <rect x='11.2852' y='9.40039' width='16' height='2.66667' rx='1.33333' transform='rotate(45 11.2852 9.40039)' fill='currentColor'/>
                                                </svg>
                                                </span></button>
                                            <button class='btn btn-icon btn-dark custom_label_body' onclick='save_custom_label()'><span class='svg-icon svg-icon-muted svg-icon-2hx'><svg width='24' height='24' viewBox='0 0 24 24' fill='none' xmlns='http://www.w3.org/2000/svg'>
                                                <path opacity='0.3' d='M10 18C9.7 18 9.5 17.9 9.3 17.7L2.3 10.7C1.9 10.3 1.9 9.7 2.3 9.3C2.7 8.9 3.29999 8.9 3.69999 9.3L10.7 16.3C11.1 16.7 11.1 17.3 10.7 17.7C10.5 17.9 10.3 18 10 18Z' fill='currentColor'/>
                                                <path d='M10 18C9.7 18 9.5 17.9 9.3 17.7C8.9 17.3 8.9 16.7 9.3 16.3L20.3 5.3C20.7 4.9 21.3 4.9 21.7 5.3C22.1 5.7 22.1 6.30002 21.7 6.70002L10.7 17.7C10.5 17.9 10.3 18 10 18Z' fill='currentColor'/>
                                                </svg>
                                                </span></button>
                                                </div>   
                                    </div>
                                " data-original-title="" title="">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="10" fill="currentColor" />
                                <rect x="10.8891" y="17.8033" width="12" height="2" rx="1"
                                    transform="rotate(-90 10.8891 17.8033)" fill="currentColor" />
                                <rect x="6.01041" y="10.9247" width="12" height="2" rx="1" fill="currentColor" />
                            </svg>
                        </span>
                    </div>


                </div>
            </div>
            <div class="row">
                <div class="  items-list d-flex align-items-center my-1 py-3 bg-light  rounded-1"
                    style="position: relative; text-wrap:nowrap; width:100%;" id="items_list">
                    <div class="kt-dark fw-bold fs-6 lh-lg  w-75">
                        Item listing Table
                    </div>
                    <div class="d-flex h-25px w-80px flex-shrink-0 flex-center position-relative ms-3 me-6">

                        <!--begin::Svg Icon | path: icons/duotune/art/art006.svg-->
                        <span class="svg-icon svg-icon-2x svg-icon-info position-absolute" title=""
                            onclick="show_detail_listing_table()">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path opacity="0.3"
                                    d="M22.1 11.5V12.6C22.1 13.2 21.7 13.6 21.2 13.7L19.9 13.9C19.7 14.7 19.4 15.5 18.9 16.2L19.7 17.2999C20 17.6999 20 18.3999 19.6 18.7999L18.8 19.6C18.4 20 17.8 20 17.3 19.7L16.2 18.9C15.5 19.3 14.7 19.7 13.9 19.9L13.7 21.2C13.6 21.7 13.1 22.1 12.6 22.1H11.5C10.9 22.1 10.5 21.7 10.4 21.2L10.2 19.9C9.4 19.7 8.6 19.4 7.9 18.9L6.8 19.7C6.4 20 5.7 20 5.3 19.6L4.5 18.7999C4.1 18.3999 4.1 17.7999 4.4 17.2999L5.2 16.2C4.8 15.5 4.4 14.7 4.2 13.9L2.9 13.7C2.4 13.6 2 13.1 2 12.6V11.5C2 10.9 2.4 10.5 2.9 10.4L4.2 10.2C4.4 9.39995 4.7 8.60002 5.2 7.90002L4.4 6.79993C4.1 6.39993 4.1 5.69993 4.5 5.29993L5.3 4.5C5.7 4.1 6.3 4.10002 6.8 4.40002L7.9 5.19995C8.6 4.79995 9.4 4.39995 10.2 4.19995L10.4 2.90002C10.5 2.40002 11 2 11.5 2H12.6C13.2 2 13.6 2.40002 13.7 2.90002L13.9 4.19995C14.7 4.39995 15.5 4.69995 16.2 5.19995L17.3 4.40002C17.7 4.10002 18.4 4.1 18.8 4.5L19.6 5.29993C20 5.69993 20 6.29993 19.7 6.79993L18.9 7.90002C19.3 8.60002 19.7 9.39995 19.9 10.2L21.2 10.4C21.7 10.5 22.1 11 22.1 11.5ZM12.1 8.59998C10.2 8.59998 8.6 10.2 8.6 12.1C8.6 14 10.2 15.6 12.1 15.6C14 15.6 15.6 14 15.6 12.1C15.6 10.2 14 8.59998 12.1 8.59998Z"
                                    fill="currentColor" />
                                <path
                                    d="M17.1 12.1C17.1 14.9 14.9 17.1 12.1 17.1C9.30001 17.1 7.10001 14.9 7.10001 12.1C7.10001 9.29998 9.30001 7.09998 12.1 7.09998C14.9 7.09998 17.1 9.29998 17.1 12.1ZM12.1 10.1C11 10.1 10.1 11 10.1 12.1C10.1 13.2 11 14.1 12.1 14.1C13.2 14.1 14.1 13.2 14.1 12.1C14.1 11 13.2 10.1 12.1 10.1Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                    </div>


                </div>
            </div>
            <div class="row  " id="items-drag">


                <?php

$barcode = 'false';
$logo = 'false';
$custom_logo = 'false';
$items_list = 'false';



$dynamic_variable_names = []; 
$dynamic_variable_values = [];
foreach ($labels as $item) {
    // Create a variable with the name from label_name
    $variable_name = $item['label_name'];  // Get the label name
    $$variable_name = 'false';  // Assign label_text to the variable
	$dynamic_variable_names[] = $variable_name;
	$dynamic_variable_values[$variable_name] = $item['label_text'];
}

foreach ($labels as $item) {
    // Create a variable with the name from label_name
    $variable_name = $item['label_name'];  // Get the label name


}



$i = 0;
$custom_images =[];
$shapes =[];
$lines =[];
$positions_array =[];
if (count($positions) > 0) :

	foreach ($positions as $subArray) {


		if (isset($subArray->id)){
        $positions_array[$subArray->id] = (array) $subArray;

		
			$string  = $subArray->id;
			
			if (strpos($string, 'custom_img_header_') !== false) {
				// Extract the number after 'custom_img_'
				preg_match('/custom_img_header_(\d+)/', $string, $matches);
				
				if (!empty($matches)) {
					$number = $matches[1];  
					$custom_images[$i]['number'] = $number;
					$custom_images[$i]['type'] = 'header';
					$custom_images[$i]['position'] = $subArray->id;
				}
		 
			} 
			if (strpos($string, 'custom_img_body_') !== false) {
				// Extract the number after 'custom_img_'
				preg_match('/custom_img_body_(\d+)/', $string, $matches);
				
				if (!empty($matches)) {
					$number = $matches[1];  
					$custom_images[$i]['number'] = $number;
					$custom_images[$i]['type'] = 'body';
					$custom_images[$i]['position'] = $subArray->id;
				} 
			} 
			if (strpos($string, 'custom_img_footer_') !== false) {
				// Extract the number after 'custom_img_'
				preg_match('/custom_img_footer_(\d+)/', $string, $matches);
				
				if (!empty($matches)) {
					$number = $matches[1];  
					$custom_images[$i]['number'] = $number;
					$custom_images[$i]['type'] = 'footer';
					$custom_images[$i]['position'] = $subArray->id;
				} 
			} 


			if (strpos($string, 'rectangle_header_') !== false) {
				// Extract the number after 'rectangle_'
				preg_match('/rectangle_header_(\d+)/', $string, $matches);
				
				if (!empty($matches)) {
					$number = $matches[1];  
					$shapes[$i]['number'] = $number;
					$shapes[$i]['type'] = 'header';
					$shapes[$i]['position'] = $subArray->id;
				}
		 
			} 
			if (strpos($string, 'rectangle_body_') !== false) {
				// Extract the number after 'rectangle_'
				preg_match('/rectangle_body_(\d+)/', $string, $matches);
				
				if (!empty($matches)) {
					$number = $matches[1];  
					$shapes[$i]['number'] = $number;
					$shapes[$i]['type'] = 'body';
					$shapes[$i]['position'] = $subArray->id;
				} 
			} 
			if (strpos($string, 'rectangle_footer_') !== false) {
				// Extract the number after 'rectangle_'
				preg_match('/rectangle_footer_(\d+)/', $string, $matches);
				
				if (!empty($matches)) {
					$number = $matches[1];  
					$shapes[$i]['number'] = $number;
					$shapes[$i]['type'] = 'footer';
					$shapes[$i]['position'] = $subArray->id;
				} 
			} 


			if (strpos($string, 'border_line_header_') !== false) {
				// Extract the number after 'border_line_'
				preg_match('/border_line_header_(\d+)/', $string, $matches);
				
				if (!empty($matches)) {
					$number = $matches[1];  
					$lines[$i]['number'] = $number;
					$lines[$i]['type'] = 'header';
					$lines[$i]['position'] = $subArray->id;
				}
		 
			}  
			if (strpos($string, 'border_line_body_') !== false) {
				// Extract the number after 'border_line_'
				preg_match('/border_line_body_(\d+)/', $string, $matches);
				
				if (!empty($matches)) {
					$number = $matches[1];  
					$lines[$i]['number'] = $number;
					$lines[$i]['type'] = 'body';
					$lines[$i]['position'] = $subArray->id;
				} 
			} 
			if (strpos($string, 'border_line_footer_') !== false) {
				// Extract the number after 'border_line_'
				preg_match('/border_line_footer_(\d+)/', $string, $matches);
				
				if (!empty($matches)) {
					$number = $matches[1];  
					$lines[$i]['number'] = $number;
					$lines[$i]['type'] = 'footer';
					$lines[$i]['position'] = $subArray->id;
				} 
			} 
		}
		
		if (isset($subArray->id) && $subArray->id === 'logo') {
			$logo = $i;
		}
		if (isset($subArray->id) && $subArray->id === 'custom_logo') {
			$custom_logo = $i;
		}
		if (isset($subArray->id) && $subArray->id === 'items_list') {

			$items_list = $i;
		}
		if (isset($subArray->id) && $subArray->id === 'barcode') {
			$barcode = $i;
		}

		foreach ($dynamic_variable_names as $dynamic_name) {
			if (isset($subArray->id) && $subArray->id === $dynamic_name) {
				$$dynamic_name = $i;  // Assign the variable name dynamically
			}
		}

		
		
		$i++;
	}
endif;

// echo "<pre>";
// print_r($lines);
// exit();

foreach ($dynamic_variable_names as $dynamic_name) {
		
			?>


                <div class=" d-flex align-items-center my-1 py-3 bg-light  rounded-1 "
                    style="position: relative; text-wrap:nowrap; width:100%;">
                    <!--begin::Icon-->
                    <div class="d-flex h-25px w-15 flex-shrink-0 flex-center position-relative ms-3 me-6">

                        <!--begin::Svg Icon | path: icons/duotune/art/art006.svg-->
                        <span class="svg-icon svg-icon-2x svg-icon-info position-absolute">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4 6C5.10457 6 6 5.10457 6 4C6 2.89543 5.10457 2 4 2C2.89543 2 2 2.89543 2 4C2 5.10457 2.89543 6 4 6Z"
                                    fill="currentColor" />
                                <path opacity="0.3"
                                    d="M14 12C14 13.1 13.1 14 12 14C10.9 14 10 13.1 10 12C10 10.9 10.9 10 12 10C13.1 10 14 10.9 14 12ZM4 10C2.9 10 2 10.9 2 12C2 13.1 2.9 14 4 14C5.1 14 6 13.1 6 12C6 10.9 5.1 10 4 10ZM20 10C18.9 10 18 10.9 18 12C18 13.1 18.9 14 20 14C21.1 14 22 13.1 22 12C22 10.9 21.1 10 20 10ZM12 2C10.9 2 10 2.9 10 4C10 5.1 10.9 6 12 6C13.1 6 14 5.1 14 4C14 2.9 13.1 2 12 2ZM20 2C18.9 2 18 2.9 18 4C18 5.1 18.9 6 20 6C21.1 6 22 5.1 22 4C22 2.9 21.1 2 20 2ZM12 18C10.9 18 10 18.9 10 20C10 21.1 10.9 22 12 22C13.1 22 14 21.1 14 20C14 18.9 13.1 18 12 18ZM4 18C2.9 18 2 18.9 2 20C2 21.1 2.9 22 4 22C5.1 22 6 21.1 6 20C6 18.9 5.1 18 4 18ZM20 18C18.9 18 18 18.9 18 20C18 21.1 18.9 22 20 22C21.1 22 22 21.1 22 20C22 18.9 21.1 18 20 18Z"
                                    fill="currentColor" />
                            </svg>
                        </span>


                    </div>

                    <div class="kt-dark fw-bold fs-6 lh-lg  w-60">
                        <?php echo $dynamic_variable_values[$dynamic_name]; 
                        
                        
                        ?>
                    </div>

                    <span class="svg-icon svg-icon-gray-800 svg-icon-2hx pull-right" data-placement="left"
                        data-toggle="popover" data-html="true" data-content="
											<div class='popover-header'>Action</div>
												<div class='popover-body w-150px p-0'>
                                                    <div class='form-check form-check-custom form-check-solid form-check-sm'>
                                                        <input class='form-check-input' type='checkbox'  <?php  if(isset($positions_array['header-'.$dynamic_name]) && $positions_array['header-'.$dynamic_name]['display'] =='block'  ){ echo "checked"; } ?> value='' onclick='hide_show_label(&#34;header-<?php echo $dynamic_name; ?>&#34;)'  id='header-<?php echo $dynamic_name; ?>' />
                                                        <label class='form-check-label' for='header-<?php echo $dynamic_name; ?>'>
                                                           Insert into header
                                                        </label>
                                                    </div>
                                                    <div class='form-check form-check-custom form-check-solid form-check-sm'>
                                                        <input class='form-check-input' type='checkbox' value='' <?php  if(isset($positions_array['footer-'.$dynamic_name]) && $positions_array['footer-'.$dynamic_name]['display'] =='block'  ){ echo "checked"; } ?> onclick='hide_show_label(&#34;footer-<?php echo $dynamic_name; ?>&#34;)' id='footer-<?php echo $dynamic_name; ?>'/>
                                                        <label class='form-check-label' for='footer-<?php echo $dynamic_name; ?>'>
                                                        Insert into footer
                                                        </label>
                                                    </div>
                                                    <div class='form-check form-check-custom form-check-solid form-check-sm'>
                                                        <input class='form-check-input' type='checkbox' value='' <?php  if(isset($positions_array['body-'.$dynamic_name]) && $positions_array['body-'.$dynamic_name]['display'] =='block'  ){ echo "checked"; } ?>  onclick='hide_show_label(&#34;body-<?php echo $dynamic_name; ?>&#34;)' id='body-<?php echo $dynamic_name; ?>' />
                                                        <label class='form-check-label' for='body-<?php echo $dynamic_name; ?>'>
                                                        Insert into body
                                                        </label>
                                                    </div>
													
												</div>
											">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="4" fill="currentColor" />
                            <rect x="11" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                            <rect x="15" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                            <rect x="7" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                        </svg>
                    </span>
                </div>

                <?php
		
}





?>


                <div class="d-flex align-items-center my-1 py-3 bg-light  rounded-1 "
                    style="position: relative; text-wrap:nowrap; width:100%;" id="custom_logo">
                    <!--begin::Icon-->
                    <div class="d-flex h-25px w-15 flex-shrink-0 flex-center position-relative ms-3 me-6">

                        <!--begin::Svg Icon | path: icons/duotune/art/art006.svg-->
                        <span class="svg-icon svg-icon-2x svg-icon-info position-absolute">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M4 6C5.10457 6 6 5.10457 6 4C6 2.89543 5.10457 2 4 2C2.89543 2 2 2.89543 2 4C2 5.10457 2.89543 6 4 6Z"
                                    fill="currentColor" />
                                <path opacity="0.3"
                                    d="M14 12C14 13.1 13.1 14 12 14C10.9 14 10 13.1 10 12C10 10.9 10.9 10 12 10C13.1 10 14 10.9 14 12ZM4 10C2.9 10 2 10.9 2 12C2 13.1 2.9 14 4 14C5.1 14 6 13.1 6 12C6 10.9 5.1 10 4 10ZM20 10C18.9 10 18 10.9 18 12C18 13.1 18.9 14 20 14C21.1 14 22 13.1 22 12C22 10.9 21.1 10 20 10ZM12 2C10.9 2 10 2.9 10 4C10 5.1 10.9 6 12 6C13.1 6 14 5.1 14 4C14 2.9 13.1 2 12 2ZM20 2C18.9 2 18 2.9 18 4C18 5.1 18.9 6 20 6C21.1 6 22 5.1 22 4C22 2.9 21.1 2 20 2ZM12 18C10.9 18 10 18.9 10 20C10 21.1 10.9 22 12 22C13.1 22 14 21.1 14 20C14 18.9 13.1 18 12 18ZM4 18C2.9 18 2 18.9 2 20C2 21.1 2.9 22 4 22C5.1 22 6 21.1 6 20C6 18.9 5.1 18 4 18ZM20 18C18.9 18 18 18.9 18 20C18 21.1 18.9 22 20 22C21.1 22 22 21.1 22 20C22 18.9 21.1 18 20 18Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                    </div>

                    <div class="kt-dark fw-bold fs-6 lh-lg  w-60">
                        <?php echo img(
			array(
				'src' => $img_logo_image,
                'width' => '50px'


			)
		); ?>
                    </div>


                    <span class="svg-icon svg-icon-gray-800 svg-icon-2hx pull-right" data-placement="left"
                        data-toggle="popover" data-html="true" data-content="
											<div class='popover-header'>Action</div>
												<div class='popover-body w-150px p-0'>
                                                    <div class='form-check form-check-custom form-check-solid form-check-sm'>
                                                        <input class='form-check-input' type='checkbox'  <?php  if(isset($positions_array['header--logo']) && $positions_array['header-logo']['display'] =='block'  ){ echo "checked"; } ?> value='' onclick='insert_logo(&#34;header-logo&#34;)'  id='header-logo' />
                                                        <label class='form-check-label' for='header-logo'>
                                                           Insert into header
                                                        </label>
                                                    </div>
                                                    <div class='form-check form-check-custom form-check-solid form-check-sm'>
                                                        <input class='form-check-input' type='checkbox' value='' <?php  if(isset($positions_array['footer-']) && $positions_array['footer-logo']['display'] =='block'  ){ echo "checked"; } ?> onclick='insert_logo(&#34;footer-logo&#34;)' id='footer-logo'/>
                                                        <label class='form-check-label' for='footer-logo'>
                                                        Insert into footer
                                                        </label>
                                                    </div>
                                                    <div class='form-check form-check-custom form-check-solid form-check-sm'>
                                                        <input class='form-check-input' type='checkbox' value='' <?php  if(isset($positions_array['body-logo']) && $positions_array['body-logo']['display'] =='block'  ){ echo "checked"; } ?>  onclick='insert_logo(&#34;body-logo&#34;)' id='body-logo' />
                                                        <label class='form-check-label' for='body-logo'>
                                                        Insert into body
                                                        </label>
                                                    </div>
													
												</div>
											">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect opacity="0.3" x="2" y="2" width="20" height="20" rx="4" fill="currentColor" />
                            <rect x="11" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                            <rect x="15" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                            <rect x="7" y="11" width="2.6" height="2.6" rx="1.3" fill="currentColor" />
                        </svg>
                    </span>
                </div>






            </div>

        </div>
    </div>
    <!--begin::Card-->
    <div class="card card-docs flex-row-fluid mb-2  w-75">
        <!--begin::Card Body-->
        <div class="card-body fs-6  text-gray-700">

            <!--begin::Section-->
            <div class="pt-10">
                <!--begin::Heading-->
                <div class="hidden-print">
                    <h1 class="anchor fw-bold mb-5 hidden-print" data-kt-scroll-offset="85" id="swappable">
                        <a href="#swappable" data-kt-scroll-toggle=""></a><?= $receipt['title'] ?>
                    </h1>


                </div>
            </div>

            <!--end::Heading-->
            <!--end::Block-->
            <!--begin::Block-->
            <div class="py-5">
                <!--begin::Row-->
                <div class="row  g-10">

                    <!--begin::Col-->
                    <div class="col-md-12">
                        <!--begin::Card-->
                        <div class="card card-bordered">
                            <!--begin::Card header-->
                            <div class="card-header hidden-print">
                                <div class="card-toolbar ">
                                    <div class="d-flex justify-content-end gap-2">
                                        <select class="form-select form-select-solid text_based_config" style="display:none"
                                            id="font-size-selector" aria-label="Select example">
                                            <option> Font Size</option>
                                            <?php for($i=1; $i <= 72; $i++): ?>
                                            <option value="<?= $i ?>px"><?= $i ?>px</option>
                                            <?php endfor; ?>
                                        </select>
                                        <select class="form-select form-select-solid text_based_config" style="display:none"
                                            id="font-weight-selector" aria-label="Select example">
                                            <option> Font weight</option>
                                            <option value="100">100</option>
                                            <option value="200">200</option>
                                            <option value="300">300</option>
                                            <option value="400">400</option>
                                            <option value="500">500</option>
                                            <option value="600">600</option>
                                            <option value="700">700</option>
                                            <option value="800">800</option>
                                        </select>
                                        <div class="  text_based_config " style="display:none">
                                            <div class="d-flex">
                                                <?php echo form_label(lang('color').':', 'color',array('class'=>' pt-3   control-label')); ?>

                                                <?php echo form_input(array(
															'autocomplete' =>'off',
															'class'=>'form-control form-inps w-100px mx-2',
															'name'=>'color',
															'id'=>'color',
															'value'=>'')
														);?>
                                            </div>
                                        </div>
                                        <div class="  text_based_config " style="display:none">
                                            <button type="button" class="btn btn-danger remove-btn">Remove</button>
                                        </div>

                                        <div class="  table_based_config" style="display:none">
                                            <div class="d-flex gap-1">
                                                <img width="50px" height="50px" onclick="add_table_border('all' , this)" class="tbl_all_borders"  data-is_active="<?= ($receipt['tbl_all_borders'])?'true':'false'?>"
                                                    src="<?= base_url('assets/css_good/media/all-border.png') ?>" >
                                                <img width="50px" height="50px" onclick="add_table_border('horizontal' , this)" class="tbl_horzontal_borders"   data-is_active="<?= ($receipt['tbl_horzontal_borders'])?'true':'false'?>"
                                                    src="<?= base_url('assets/css_good/media/horizontal-border.png') ?>" >
                                                <img width="50px" height="50px" onclick="add_table_border('vertical' , this)" class="tbl_vertical_borders"   data-is_active="<?= ($receipt['tbl_vertical_borders'])?'true':'false'?>"
                                                    src="<?= base_url('assets/css_good/media/vertical-border.png') ?>">
												<div class="tbl-head-icon-container tbl_header_bg " onclick="add_table_border('header' , this)"   data-is_active="<?= ($receipt['tbl_header_bg'])?'true':'false'?>">
													<span class="svg-icon  table-header-icon"  style="color:black"><svg
                                                        width="20" height="21" viewBox="0 0 20 21" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3"
                                                            d="M19 3.40002C18.4 3.40002 18 3.80002 18 4.40002V8.40002H14V4.40002C14 3.80002 13.6 3.40002 13 3.40002C12.4 3.40002 12 3.80002 12 4.40002V8.40002H8V4.40002C8 3.80002 7.6 3.40002 7 3.40002C6.4 3.40002 6 3.80002 6 4.40002V8.40002H2V4.40002C2 3.80002 1.6 3.40002 1 3.40002C0.4 3.40002 0 3.80002 0 4.40002V19.4C0 20 0.4 20.4 1 20.4H19C19.6 20.4 20 20 20 19.4V4.40002C20 3.80002 19.6 3.40002 19 3.40002ZM18 10.4V13.4H14V10.4H18ZM12 10.4V13.4H8V10.4H12ZM12 15.4V18.4H8V15.4H12ZM6 10.4V13.4H2V10.4H6ZM2 15.4H6V18.4H2V15.4ZM14 18.4V15.4H18V18.4H14Z"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M19 0.400024H1C0.4 0.400024 0 0.800024 0 1.40002V4.40002C0 5.00002 0.4 5.40002 1 5.40002H19C19.6 5.40002 20 5.00002 20 4.40002V1.40002C20 0.800024 19.6 0.400024 19 0.400024Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                	</span>
												</div>
                                               
                                            </div>

                                        </div>
                                        <select class="form-select form-select-solid img_based_config"
                                            id="table_image_position" name="table_image_position"
                                            aria-label="Select example" style="display:none">
                                            <option> Table Image Position</option>
                                            <option value="just-content-start">Bottom left</option>
                                            <option value="justify-content-center">Bottom Center</option>
                                            <option value="justify-content-end">Bottom Right</option>
                                            <option value="left-side-of-item">Left Side of item</option>
                                        </select>
                                        <div class="  img_based_config" style="display:none">
                                            <div class="d-flex">
                                                <?php echo form_label(lang('table image size').':', 'table_image_size',array('class'=>' pt-3  w-150px  control-label')); ?>

                                                <?php echo form_input(array(
													'type' =>'number',
													'autocomplete' =>'off',
													'class'=>'form-control form-inps w-100px mx-2',
													'name'=>'table_image_size',
													'id'=>'table_image_size',
													'value'=>'50')
												);?>
                                            </div>
                                        </div>





                                    </div>
                                </div>


                            </div>


                            <!--end::Card header-->
                            <!--begin::Card body-->
                            <div id="printzone">
                                <?php

									if ($receipt['background_image']) {
										$img_background_image = cacheable_app_file_url($receipt['background_image']);
									}
                                 
                                    $pages  = ['one' , 'two' , 'three'];
                                    foreach($pages as $page): ?>


                                <div class="card-body elementWithBackground  page-<?=  $page; ?> <?= $receipt['size'] ?> p-0 m-auto"
                                    id="receipt_wrapper_inner"
                                    <?php if ($receipt['background_image']) { ?>style="  background-size: contain; background-position: center top;  
                                            background-repeat: repeat-y;   background-image: url(<?= $img_background_image; ?>)" <?php } ?>>
                                    <!--begin::Row-->
                                    <?php 
                                                                                $parts = ['header' , 'body' , 'footer'];
                                                                                foreach ($parts as $part) {
                                                                            ?>
                                    <div class="row row-cols-1 g-10  page_<?= $part; ?>"
                                        style="height:<?= $receipt[''.$part.'_percentage'] ?>">
                                        <?php

									// Filter the array to include only items with 'rectangle' in the id
											
											// If you need to access the filtered array, you can loop through $filteredPositions
											if(count($shapes) > 0){ 
											foreach ($shapes as $key => $cus) {
												if($cus['type']==$part){
												// Access your properties like $position->id, $position->newleft, etc.
												 ?>
                                        <div class="resize transparent-rectangle <?= $positions_array[$cus['position']]['newtype']; ?>-border"
                                            style="position: absolute; width:<?= $positions_array[$cus['position']]['newwidth'];  ?>px;height:<?= $positions_array[$cus['position']]['newheight'];  ?>px; text-wrap:nowrap; left:<?= $positions_array[$cus['position']]['newleft'];  ?>; top:<?= $positions_array[$cus['position']]['newtop'];  ?>; "
                                            data-left="<?= $positions_array[$cus['position']]['newleft'];  ?>"
                                            data-top="<?= $positions_array[$cus['position']]['newtop'];  ?>"
                                            data-type="<?= $positions_array[$cus['position']]['newtype'];  ?>"
                                            data-current_width="<?= $positions_array[$cus['position']]['newwidth'];  ?>"
                                            data-current_height="<?= $positions_array[$cus['position']]['newheight'];  ?>"
                                            id="rectangle_<?= $part;  ?>_<?= $cus['number'];  ?>">
                                            <span
                                                class="position-absolute top-0 start-0 translate-middle  badge badge-circle badge-danger remove_shape">x</span>
                                            <?php 
													if($positions_array[$cus['position']]['newtype']!=''){
														if($positions_array[$cus['position']]['newtype'] == 'triangle-up'){
                                                           ?>
                                            <div class="triangle-up-border"><svg viewBox="0 0 100 100"
                                                    preserveAspectRatio="none"
                                                    style="width: 100%; height: 100%; display: block;">
                                                    <polygon points="50,0 0,100 100,100" fill="transparent"
                                                        stroke="#646e84" stroke-width="2" />
                                                </svg></div>
                                            <?php 
                                                        }
													}

													if($positions_array[$cus['position']]['newtype']!=''){
														if($positions_array[$cus['position']]['newtype'] == 'triangle-down'){
                                                           ?>
                                            <div class="triangle-down-border"><svg viewBox="0 0 100 100"
                                                    preserveAspectRatio="none"
                                                    style="width: 100%; height: 100%; display: block;">
                                                    <polygon points="50,100 0,0 100,0" fill="transparent"
                                                        stroke="#646e84" stroke-width="2" />
                                                </svg></div>
                                            <?php 
                                                        }
													}
												?>
                                        </div>

                                        <?php 
											}
										}

										}
										if(count($lines) > 0){ 
											foreach($lines  as $key => $cus){
												if($cus['type']==$part){
											// Access your properties like $position->id, $position->newleft, etc.
											 ?>
                                        <div class="resize border_line border-top-<?= $positions_array[$cus['position']]['newtype'];  ?>"
                                            style="position: absolute; width:<?= $positions_array[$cus['position']]['newwidth'];  ?>px;height:<?= $positions_array[$cus['position']]['newheight'];  ?>px; text-wrap:nowrap; left:<?= $positions_array[$cus['position']]['newleft'];  ?>; top:<?= $positions_array[$cus['position']]['newtop'];  ?>; "
                                            data-left="<?= $positions_array[$cus['position']]['newleft'];  ?>"
                                            data-top="<?= $positions_array[$cus['position']]['newtop'];  ?>"
                                            data-current_width="<?= $positions_array[$cus['position']]['newwidth'];  ?>"
                                            data-current_height="<?= $positions_array[$cus['position']]['newheight'];  ?>"
                                            id="border_line_<?= $part;  ?>_<?= $cus['number'];  ?>">
                                            <span
                                                class="position-absolute top-0 start-0 translate-middle  badge badge-circle badge-danger remove_shape">x</span>
                                        </div>

                                        <?php 
										}
									}
								}
								if(count($custom_images) > 0){ 
											
											foreach($custom_images  as $key => $cus){
												if($cus['type']==$part){

												
											?>
                                        <div class=" draggable resize "
                                            style="position: absolute; width:<?= $positions_array[$cus['position']]['newwidth'];  ?>px;height:<?= $positions_array[$cus['position']]['newheight'];  ?>px; text-wrap:nowrap; left:<?= $positions_array[$cus['position']]['newleft'];  ?>; top:<?= $positions_array[$cus['position']]['newtop'];  ?>; "
                                            data-left="<?= $positions_array[$cus['position']]['newleft'];  ?>"
                                            data-top="<?= $positions_array[$cus['position']]['newtop'];  ?>"
                                            data-current_width="<?= $positions_array[$cus['position']]['newwidth'];  ?>"
                                            data-current_height="<?= $positions_array[$cus['position']]['newheight'];  ?>"
                                            id="custom_img_<?= $part;  ?>_<?= $cus['number'];  ?>">
                                            <?php echo img(
														array(
															'src' => cacheable_app_file_url($cus['number']),

														)
													); ?>
                                            <span class="drag-handle">
                                                <span class="svg-icon svg-icon-muted svg-icon"><svg width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3"
                                                            d="M2 9.09998V3C2 2.4 2.4 2 3 2H9.10001L2 9.09998ZM22 9.09998V3C22 2.4 21.6 2 21 2H14.9L22 9.09998ZM2 14.9V21C2 21.6 2.4 22 3 22H9.10001L2 14.9ZM14.9 22H21C21.6 22 22 21.6 22 21V14.9L14.9 22Z"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M19.2 17.8L13.4 12L19.2 6.20001L17.8 4.79999L12 10.6L6.2 4.79999L4.8 6.20001L10.6 12L4.8 17.8L6.2 19.2L12 13.4L17.8 19.2L19.2 17.8Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                            </span>
                                            <span
                                                class="position-absolute top-0 start-0 translate-middle  badge badge-circle badge-danger remove_img">x</span>
                                            <div class="ui-resizable-handle ui-resizable-e" id="handle-right">
                                                <i class="fa fa-ellipsis-v" style="position:absolute; top:50%"></i>
                                                <!-- FontAwesome icon class -->
                                            </div>
                                        </div>

                                        <?php } } }

									



                                                                            foreach ($dynamic_variable_names as $dynamic_name) {
                                                   
                                                                            ?>
                                        <div class="draggable        <?php  if(isset($positions_array[$part.'-'.$dynamic_name]) && $positions_array[$part.'-'.$dynamic_name]['display'] =='block'  ){ echo "already_shown"; }else { echo "already_hidden";} ?> <?= $part.'-'.$dynamic_name ?>"
                                            style="position: absolute; dddd  text-wrap:nowrap; 
                                                                            <?php  if(isset($positions_array[$part.'-'.$dynamic_name])): ?>         
                                                                                    font-weight:<?= isset($positions_array[$part.'-'.$dynamic_name]['newweight'])?$positions_array[$part.'-'.$dynamic_name]['newweight']:'normal';  ?>;
                                                                                    font-size:<?= isset($positions_array[$part.'-'.$dynamic_name]['newsize'])?$positions_array[$part.'-'.$dynamic_name]['newsize']:'11px';  ?>;
                                                                                    color:<?= isset($positions_array[$part.'-'.$dynamic_name]['newcolor'])?$positions_array[$part.'-'.$dynamic_name]['newcolor']:'#7c7676';  ?>;
                                                                                    width:auto;
                                                                                    height:auto; text-wrap:nowrap; 
                                                                                    left:<?= $positions_array[$part.'-'.$dynamic_name]['newleft'];    ?>; 
                                                                                    top:<?=  $positions_array[$part.'-'.$dynamic_name]['newtop'];    ?>; 
                                                                                    
                                                                                    <?php  if(isset($positions_array[$part.'-'.$dynamic_name]) && $positions_array[$part.'-'.$dynamic_name]['display'] =='block'  ){ echo "display:block;"; }else { echo "display:none;";} ?> 
																					<?php else: ?>
																						display:none;
                                                                                     <?php endif; ?> "
                                            <?php  if(isset($positions_array[$part.'-'.$dynamic_name])): ?>
                                            data-left="<?= $positions_array[$part.'-'.$dynamic_name]['newleft'];  ?>"
                                            data-top="<?= $positions_array[$part.'-'.$dynamic_name]['newtop'];   ?>"
                                            data-current_width="auto" data-current_height="auto"
                                            data-current_size="<?= isset($positions_array[$part.'-'.$dynamic_name]['newsize'])?$positions_array[$part.'-'.$dynamic_name]['newsize']:'11px';  ?>"
                                            data-current_weight="<?= isset($positions_array[$part.'-'.$dynamic_name]['newweight'])?$positions_array[$part.'-'.$dynamic_name]['newweight']:'normal';  ?>"
                                            data-current_color="<?= isset($positions_array[$part.'-'.$dynamic_name]['newcolor'])?$positions_array[$part.'-'.$dynamic_name]['newcolor']:'#7c7676';  ?>"
                                            <?php endif; ?> id="<?php echo $part.'-'.$dynamic_name; ?>">



                                            <?php 
                                                    if($dynamic_name=='barcode'){ ?>
                                            Change
                                            return policy <br>

                                            <img src="<?php echo base_url(); ?>barcode/index/svg?barcode=POS 43&amp;text=POS 43"
                                                alt="">
                                            <?php 

                                                    }else{
                                                        echo $dynamic_variable_values[$dynamic_name]; 
                                                    }
                                                    ?>


                                        </div>



                                        <?php
                                                    
                                            }

                                            ?>

                                        <?php
                                               
                                             
                                               if ($part == 'body') {
                                               ?>
                                        <div class=" resize table-drag" style="position: absolute;   text-wrap:nowrap; 
                                                                            <?php  if(isset($positions_array['body-items_list'])): ?>         
                                                                                    width:<?= $positions_array['body-items_list']['newwidth'];  ?>px;
                                                                                    height:<?= $positions_array['body-items_list']['newheight'];   ?>; text-wrap:nowrap; 
                                                                                    left:<?= $positions_array['body-items_list']['newleft'];    ?>; 
                                                                                    top:<?=  $positions_array['body-items_list']['newtop'];    ?>; 
                                                                                    
                                                                                    <?php  if(isset($positions_array['body-items_list']) && $positions_array['body-items_list']['display'] =='block'  ){ echo "display:block"; }else { echo "display:none";} ?>  
                                                                                  

                                                                                <?php endif; ?>
                                                                                "
                                            <?php  if(isset($positions_array['body-items_list'])): ?>
                                            data-left="<?= $positions_array['body-items_list']['newleft'];  ?>"
                                            data-top="<?= $positions_array['body-items_list']['newtop'];   ?>"
                                            data-current_width="<?= $positions_array['body-items_list']['newwidth'];  ?>"
                                            data-current_height="<?= $positions_array['body-items_list']['newheight']; ?>"
                                            <?php endif; ?> id="body-items_list">
                                            <span class="drag-handle">
                                                <span class="svg-icon svg-icon-muted svg-icon"><svg width="24"
                                                        height="24" viewBox="0 0 24 24" fill="none"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path opacity="0.3"
                                                            d="M2 9.09998V3C2 2.4 2.4 2 3 2H9.10001L2 9.09998ZM22 9.09998V3C22 2.4 21.6 2 21 2H14.9L22 9.09998ZM2 14.9V21C2 21.6 2.4 22 3 22H9.10001L2 14.9ZM14.9 22H21C21.6 22 22 21.6 22 21V14.9L14.9 22Z"
                                                            fill="currentColor" />
                                                        <path
                                                            d="M19.2 17.8L13.4 12L19.2 6.20001L17.8 4.79999L12 10.6L6.2 4.79999L4.8 6.20001L10.6 12L4.8 17.8L6.2 19.2L12 13.4L17.8 19.2L19.2 17.8Z"
                                                            fill="currentColor" />
                                                    </svg>
                                                </span>
                                            </span>
                                            <table style="width:90%; margin: 0 auto; item-table " id="receipt-draggable">


                                                <thead class="reciept_table_header" data-id="hide_show_all_headers">
                                                    <tr>
                                                        <!-- invoice heading-->
                                                        <th class="invoice-table">
                                                            <div class="d-flex" id="info-row">
															<div class="w-20 text-center img-column"
                                                                    data-id="checkbox_item_img">
                                                                    <div class="invoice-head item-img">Item
                                                                        Image</div>
                                                                </div>
                                                                <div class="w-20 text-center"
                                                                    data-id="checkbox_item_name">
                                                                    <div class="invoice-head item-name">Item
                                                                        Name</div>
                                                                </div>
                                                                <div class="w-20 text-center"
                                                                    data-id="checkbox_item_price">
                                                                    <div class="invoice-head text-right item-price">
                                                                        Price </div>
                                                                </div>
                                                                <div class="w-20 text-center"
                                                                    data-id="checkbox_item_quantity">
                                                                    <div class="invoice-head text-right item-qty">
                                                                        Qty.
                                                                    </div>
                                                                </div>

                                                                <div class="w-20 text-center"
                                                                    data-id="checkbox_item_total">
                                                                    <div
                                                                        class="invoice-head pull-right item-total gift_receipt_element">
                                                                        Total</div>
                                                                </div>

                                                            </div>
                                                        </th>
                                                    </tr>
                                                </thead>


                                                <tbody data-line="1" data-sale-id="43" data-item-id="5"
                                                    data-item-name="Burger food" data-item-qty="1.0000000000"
                                                    data-item-price="33" data-item-total="33" data-item-class="item">
                                                    <tr class="invoice-item-details">
                                                        <!-- invoice items-->
                                                        <td class="invoice-table-content">
                                                            <div class="d-flex receipt-row-item-holder m-0 w-100" >
															<div class="w-20  img-column" data-id="checkbox_item_img">
                                                                            <?php
                                                                        echo img(array(
                                                                            'src' => $img_logo_image,
                                                                            'class' => 'table_image side_image'
                                                                        ));
                                                                        ?>
                                                                        </div>
                                                                <div class="w-20 table-data-column " data-id="checkbox_item_name">
                                                                    <div class="invoice-content invoice-con">
                                                                       

                                                                        <div class="invoice-content-heading"
                                                                            data-id="checkbox_item_name">
                                                                            Burger food
                                                                        </div>

                                                                        <div class="invoice-desc"
                                                                            data-id="checkbox_element_variation_name">
                                                                            variant name
                                                                        </div>
                                                                        <div class="invoice-desc"
                                                                            data-id="checkbox_element_description">
                                                                            description
                                                                        </div>
                                                                        <div class="invoice-desc"
                                                                            data-id="checkbox_element_item_serialnumber">
                                                                            sn0021212312
                                                                        </div>
                                                                        <div class="invoice-desc"
                                                                            data-id="checkbox_custom_fields_to_display">
                                                                            item custom field
                                                                        </div>
                                                                        <div class="invoice-desc"
                                                                            data-id="checkbox_element_item_kit_info_name">
                                                                            item kit name
                                                                        </div>
                                                                        <div class="invoice-desc"
                                                                            data-id="checkbox_element_item_kit_custom_fields_to_display">
                                                                            item kit custom field
                                                                        </div>
                                                                        <div class="invoice-desc"
                                                                            data-id="checkbox_element_discount">
                                                                            discount
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="w-20  gift_receipt_element table-data-column"
                                                                    data-id="checkbox_item_price">
                                                                    <div class="invoice-content item-price text-right">


                                                                        $33.00 </div>
                                                                </div>
                                                                <div class="w-20  table-data-column" data-id="checkbox_item_quantity">
                                                                    <div class="invoice-content item-qty text-right">
                                                                        1
                                                                    </div>
                                                                </div>

                                                                <div class="w-20 gift_receipt_element table-data-column"
                                                                    data-id="checkbox_item_total">
                                                                    <div class="invoice-content item-total pull-right">
                                                                        $33.00
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="d-flex checkbox_element_image "
                                                                    id="checkbox_element_image"
                                                                    data-id="checkbox_element_image">
                                                                    <?php
                                                                   echo img(array(
                                                                       'src' => $img_logo_image,
                                                                       'style' => 'width:50px',
                                                                       'class' => 'table_image bottom_image ms-4'
                                                                   ));
                                                                   ?>
                                                                </div>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                </tbody>

                                            </table>
                                            <div class="ui-resizable-handle ui-resizable-e" id="handle-right">
                                                <i class="fa fa-ellipsis-v" style="position:absolute; top:50%"></i>
                                                <!-- FontAwesome icon class -->
                                            </div>
                                        </div>
                                        <?php } ?>

                                    </div>
                                    <?php }
    
                                                ?>

                                </div>
                                <?php  endforeach; ?>
                                <div>


                                </div>
                            </div>
                            <!--end::Row-->
                        </div>
                        <!--end::Card body-->
                    </div>
                    <!--end::Card-->
                </div>
                <!--end::Col-->
            </div>
            <!--end::Row-->

            <!--end::Block-->
            <!--begin::Code-->

        </div>
        <!--end::Section-->
    </div>
    <!--end::Card Body-->
</div>
<!--end::Card-->
</div>
<!--end::Container-->
</div>
<script>


function add_table_border(type, f , is_click=true) {
	console.log("type",type);
    var isActive = $(f).attr('data-is_active');
	if(!is_click){
		isActive = (isActive=='true')?'false':'true';
	}
	
    if (isActive=='false') {
        switch (type) {
            case 'all':
				console.log("all",isActive);
                // Add borders to each cell
                $('.reciept_table_header, .reciept_table_header .w-25, .invoice-table-content').css({
                    'border': '1px solid black'
                });
                break;
            case 'horizontal':
				
                // Add horizontal lines
                $('.receipt-row-item-holder .w-20').css({
                    'border-bottom': '1px solid black'
                });
                break;
            case 'vertical':
                // Add vertical lines
                $('.receipt-row-item-holder .w-20').css({
                    'border-left': '1px solid black'
                });
                break;
            default:
                // Add header background
                $('.reciept_table_header').css({
                    'background-color': 'gray',
					'border': '1px solid black'
                });
                break;
        }
    } else {
        switch (type) {
            case 'all':
                // Remove borders from each cell
                $('.reciept_table_header, .reciept_table_header .w-25, .invoice-table-content').css({
                    'border': 'none'
                });
                break;
            case 'horizontal':
                // Remove horizontal lines
                $('.receipt-row-item-holder .w-20').css({
                    'border-bottom': 'none'
                });
                break;
            case 'vertical':
                // Remove vertical lines
                $('.receipt-row-item-holder .w-20').css({
                    'border-left': 'none'
                });
                break;
            default:
                // Remove header background
                $('.reciept_table_header').css({
                    'background-color': '',
					'border': 'none'
                });
                break;
        }
    }

    // Toggle the is_active data attribute
	if(is_click){
		$(f).attr('data-is_active', (isActive=='false')?'true':'false');
	}
  
}
$(document).ready(function() {
	
	add_table_border('horizontal', $('.tbl_horzontal_borders') , false);
	add_table_border('vertical', $('.tbl_vertical_borders') , false);
	add_table_border('header', $('.tbl_header_bg') , false);
	add_table_border('all', $('.tbl_all_borders') , false);
});

$(document).ready(function() {
    $(window).scroll(function() {
        $('.popover').hide(); // Hide the popover when scrolling
    });

    var $checkbox_element_image = $('.checkbox_element_image');
    var $table_image_position = $('#table_image_position');





    function update_image_position() {
        if ($(this).val() == 'left-side-of-item') {
			
			$('.receipt-row-item-holder').find('.w-25').removeClass('w-25').addClass('w-20');


            $('.bottom_image').hide();
			$('.img-column').show();
            $('.side_image').show();
        } else {
			$('.receipt-row-item-holder').find('.w-20').removeClass('w-20').addClass('w-25');
            $('.side_image').hide();
			$('.img-column').hide();
            $('.bottom_image').show();
        }
        $checkbox_element_image.attr('class', '');
        $checkbox_element_image.attr('class', 'd-flex checkbox_element_image ' + $(this).val() + ' ');
    }

    $table_image_position.change(update_image_position);
    $table_image_position.val('<?= $receipt['table_image_position'] ?>').trigger('change');



    var $table_image = $('.table_image');
    var $table_image_size = $('#table_image_size');

    function applychangeimagesize() {

        $table_image.css({
            'width': $table_image_size.val() + 'px',
        });
    }
    $table_image.click(function() {
        // // console.log("img_based_config");
        $('.text_based_config').hide();
        $('.img_based_config').show();
		$('.table_based_config').hide();
			


        $currentimg = $(this);
        $table_image_size.focus();
        $table_image_size.val($currentimg.css('width').replace('px', ''));
    });
    $table_image_size.change(applychangeimagesize);

    $table_image_size.val('<?= $receipt['table_image_size'] ?>').trigger('change');

    var $fontSizeSelector = $('#font-size-selector');
    var $fontWeightSelector = $('#font-weight-selector');
    var $colorpicker = $('#color');

    var $currentDiv = null;

    // Function to apply font size and weight to the selected div
    function applyFontStyles() {

        if ($currentDiv) {
            $currentDiv.css({
                'font-size': $fontSizeSelector.val(),
                'font-weight': $fontWeightSelector.val(),
                'color': $colorpicker.val()
            });
            $currentDiv.attr({
                'data-current_color': $colorpicker.val(),
                'data-current_size': $fontSizeSelector.val(),
                'data-current_weight': $fontWeightSelector.val()
            });
        }
    }



	
	$('.table-data-column, thead').click(function() {
		console.log('invoice-table-content');
			$('.text_based_config').hide();
            $('.img_based_config').hide();
			$('.table_based_config').show();
	})

		
    // Update the dropdowns when a div is clicked
    $('div[id^="header-"], div[id^="footer-"], div[id^="body-"]').click(function() {


        $('div[id^="header-"], div[id^="footer-"], div[id^="body-"]').css({
            'border': 'none'
        });
        $(this).css({
            'border': '3px dotted black'
        });
        $('.menu-link[data-id="lables"]').trigger('click');
        $currentDiv = $(this); // Set the current div
        if ($currentDiv.attr('id') != 'body-items_list') {
            // // console.log('text_based_config');
            $('.text_based_config').show();
            $('.img_based_config').hide();
			$('.table_based_config').hide();
        }

        $('.remove-btn').unbind('click').click(function() {

            hide_show_label($currentDiv.attr('id'));
        });

        $fontSizeSelector.val($currentDiv.css('font-size')); // Update font size dropdown
        $fontWeightSelector.val($currentDiv.css('font-weight')); // Update font weight dropdown
        $colorpicker.val($currentDiv.css('color')); // Update font weight dropdown
        $('#color').colorpicker('setValue', $currentDiv.css('color'));

    });

    // Update the div's styles when dropdowns change
    $fontSizeSelector.change(applyFontStyles);
    $fontWeightSelector.change(applyFontStyles);
    $colorpicker.change(applyFontStyles);
    $('#color').colorpicker();
    $('#color').on('changeColor', function(event) {
        applyFontStyles();
    });
});

function hide_show_all_headers(mainCheckbox) {
    // Determine if the main checkbox is checked or not
    var isChecked = $(mainCheckbox).is(':checked');

    // Find all checkboxes with the class "heading_checkbox" and set their checked state
    // $('.heading_checkbox').prop('checked', isChecked).trigger('change');
    if (isChecked) {
        $('.reciept_table_header').hide();
    } else {
        $('.reciept_table_header').show();
    }
}

function show_hide_item_detail(id) {

    // Get the checkbox by ID
    var checkbox = $("#" + id);

    // Get the elements with the matching data-id
    var elementsToToggle = $("[data-id='" + id + "']");

    // Check the checkbox state to show or hide elements
    if (checkbox.is(":checked")) {

        elementsToToggle.show();
    } else {
        // // console.log("unchecked", id);
        elementsToToggle.hide();
    }
}


function add_rect(type, section) {
    count = $('.transparent-rectangle').length + 1;

    while ($('#rectangle_' + count).length > 0) {
        count++; // If the ID exists, increment the count and check again
    }
    $svg = '';
    $type = type + '-border';
    if (type == 'triangle-up') {
        $svg = '<div class="' + $type +
            '"><svg viewBox="0 0 100 100" preserveAspectRatio="none" style="width: 100%; height: 100%; display: block;"><polygon points="50,0 0,100 100,100" fill="transparent" stroke="#646e84" stroke-width="2" /></svg></div>';
        $type = '';
    } else if (type == 'triangle-down') {
        $svg = '<div class="' + $type +
            '"><svg viewBox="0 0 100 100" preserveAspectRatio="none" style="width: 100%; height: 100%; display: block;"><polygon points="50,100 0,0 100,0" fill="transparent" stroke="#646e84" stroke-width="2" /></svg></div>';
        $type = '';
    }

    rect = '<div class="resize transparent-rectangle  ' + $type +
        ' " style="position: absolute; text-wrap:nowrap; " id="rectangle_' + section + '_' +
        count + '" data-left="14.25px" data-top="390.296875px" data-type="' + type + '">' + $svg +
        ' <span class="position-absolute top-0 start-0 translate-middle  badge badge-circle badge-danger remove_shape">x</span></div>';

    $('.elementWithBackground').find('.page_' + section).prepend(rect);
    $(".resize").draggable({
        revert: "invalid",
        containment: "document", // Limit movement within the specified boundary.
        start: function(event, ui) {
            $(this).draggable('option', 'revert', 'invalid');
            $(this).css({
                'border': '3px dotted black'
            });
        },
        stop: function(event, ui) {
            $(this).css({
                'border': 'none'
            });
        }
    }).resizable({
        stop: function(event, ui) {
            $(this).attr('data-current_width', ui.size.width);
            $(this).attr('data-current_height', ui.size.height);
        }
    });

    $('.remove_shape').on('click', function() {
        $(this).parent().remove();
    })

}

function add_line(type, section) {
    count = $('.border_line').length + 1;

    while ($('#border_line' + count).length > 0) {
        count++; // If the ID exists, increment the count and check again
    }


    rect = '<div class="resize border_line border-top-' + type +
        ' " style="position: absolute; text-wrap:nowrap; " id="border_line_' + section + '_' + count +
        '" data-left="14.25px" data-top="390.296875px" data-type="' + type +
        '"><span class="position-absolute top-0 start-0 translate-middle  badge badge-circle badge-danger remove_shape">x</span></div>';
    $('.elementWithBackground').find('.page_' + section).prepend(rect);
    $(".resize").draggable({
        revert: "invalid",
        containment: "document", // Limit movement within the specified boundary.
        start: function(event, ui) {
            $(this).draggable('option', 'revert', 'invalid');
            $(this).css({
                'border': '3px dotted black'
            });
        },
        stop: function(event, ui) {
            $(this).css({
                'border': 'none'
            });
        }
    }).resizable({
        stop: function(event, ui) {
            $(this).attr('data-current_width', ui.size.width);
            $(this).attr('data-current_height', ui.size.height);
        }
    });
    $('.remove_shape').on('click', function() {
        $(this).parent().remove();
    })

}


function print_receipt() {
    //window.print();
    // html2canvas(document.getElementById('receipt_wrapper')).then(function(canvas) {
    // 	let imgData = canvas.toDataURL('image/png');
    // 	printJS({
    // 		printable: imgData,
    // 		type: 'image',
    // 		header: 'Your Header Here' // Optional header text
    // 	});
    // });

    let element = document.getElementById('printzone');

    // // Store original background color
    let originalBG = element.style.backgroundColor;

    // // Temporarily change the background color to white
    // element.style.backgroundColor = 'white';

    // // Capture the element with html2canvas
    // html2canvas(element).then(function(canvas) {
    //     // Revert the background color back to its original
    //     element.style.backgroundColor = originalBG;

    //     let imgData = canvas.toDataURL('image/png');
    //     printJS({
    //         printable: imgData,
    //         type: 'image',
    //     });
    // });

    const printzone = document.getElementById('printzone');
    const pages = printzone.querySelectorAll('.A4'); // Select all pages
    $('.remove_img').hide();

    function capturePage(page) {
        return new Promise((resolve, reject) => {
            html2canvas(page).then(function(canvas) {
                // Revert the background color back to its original
                page.style.backgroundColor = originalBG;

                const imgData = canvas.toDataURL('image/png');
                resolve(imgData);
            }).catch(error => {
                reject(error);
            });
        });
    }

    // Use Promise.all to capture images for all pages asynchronously
    Promise.all(Array.from(pages).map(page => capturePage(page)))
        .then(pageImages => {
            // Call printJS after all images are captured
            printJS({
                printable: pageImages,
                type: 'image',
            });
            $('.remove_img').show();
        })
        .catch(error => {
            console.error('Error capturing page images:', error);
        });




}
ClassicEditor
    .create(document.querySelector('#kt_docs_ckeditor_classicddd'))
    .then(editor => {
        // console.log(editor.getData());
        $('textarea[name="custom_text"]').val(editor.getData());

    })
    .catch(error => {
        console.error(error);
    });
$(document).ready(function() {
    $('#papersize').change(function() {
        if ($(this).val() === 'custom') {
            $('.customSizeInputs').show();
        } else {
            $('.customSizeInputs').hide();
        }
    });
});


$(function() {
    $('.remove_shape').on('click', function() {
        $(this).parent().remove();
    })
    $('.remove_img').on('click', function() {
        $(this).parent().remove();
    })


    $(".draggable").draggable({
        revert: "invalid",
        containment: "parent", // Limit movement within the specified boundary.
        start: function(event, ui) {
            // var elementId = ui.helper.attr('id');
            // localStorage.setItem('draggedHTML-'+$(this).parent().attr('id')+'-' + elementId, ui.helper[0].innerHTML);
            $(this).draggable('option', 'revert', 'invalid');
            $(this).css({
                'border': '3px dotted black'
            });
        },
        stop: function(event, ui) {
            $(this).css({
                'border': 'none'
            });
        }
    });
    $(".resize").draggable({
        revert: "invalid",
        containment: "parent", // Limit movement within the specified boundary.
        handle: ".drag-handle",
        start: function(event, ui) {
            $(this).draggable('option', 'revert', 'invalid');
            $(this).css({
                'border': '3px dotted black'
            });
        },
        stop: function(event, ui) {
            $(this).css({
                'border': 'none'
            });
        }
    }).resizable({
        handles: 'e', //east
        start: function(event, ui) {
            // console.log("resizelssd");
        },
        stop: function(event, ui) {
            $(this).attr('data-current_width', ui.size.width);
            $(this).attr('data-current_height', ui.size.height);
        }
    });


    $(".page_header, .page_body , .page_footer ").droppable({
        accept: ".draggable , .resize",
        drop: function(event, ui) {

            var elementId = ui.draggable.attr('id');

            // console.log('elementId', elementId);



            var droppedRelativeLeft = ui.offset.left - $(this).offset().left;
            var droppedRelativeTop = ui.offset.top - $(this).offset().top;
            var width = $(this).data('current_width');
            var height = $(this).data('current_height');
            // if(!custom_img && !resizer){
            // 	width = 'fit-content';
            // }

            // Append the dragged item to the drop zone
            ui.draggable.appendTo(this).css({
                top: droppedRelativeTop + 'px',
                left: droppedRelativeLeft + 'px',
                position: 'absolute',
                width: width,
                height: height,
            });
            ui.draggable.appendTo(this).attr('data-left', droppedRelativeLeft + 'px');
            ui.draggable.appendTo(this).attr('data-top', droppedRelativeTop + 'px');

            ui.draggable.appendTo(this).css({
                top: droppedRelativeTop + 'px',
                left: droppedRelativeLeft + 'px',
                position: 'absolute',
                width: width,
                height: height,
            }).attr({
                'data-left': droppedRelativeLeft + 'px',
                'data-top': droppedRelativeTop + 'px'
            }); // Removing an old class





        }
    });
    $("#dropZone ").droppable({
        accept: ".draggable , .resize",
        drop: function(event, ui) {

            var elementId = ui.draggable.attr('id');

            // Check if an element with the specified ID exists in the #dropZone div
            if ($("#dropZone").find('#' + elementId).length == 0) {




                var custom_img = false;
                var resizer =
                    '<div class="ui-resizable-handle ui-resizable-e" style="z-index: 90;"></div><div class="ui-resizable-handle ui-resizable-s" style="z-index: 90;"></div><div class="ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se" style="z-index: 90;"></div>';
                var need_resizer = false;
                var item_list =
                    '<div class="resize items-list ui-draggable ui-draggable-handle ui-resizable" style="position: relative; text-wrap:nowrap; width:20%;" id="items_list"> <table style="width:100%;" id="receipt-draggable"> <thead><tr><th class="invoice-table"> <div class="row"><div class="col-md-12 col-sm-12 col-xs-12" data-id="checkbox_item_name"><div class="invoice-head item-name">Item Name</div></div><div class="col-md-4 col-sm-4 col-xs-4 gift_receipt_element" data-id="checkbox_item_price"><div class="invoice-head text-right item-price"> Price </div></div><div class="col-md-4 col-sm-4 col-xs-4" data-id="checkbox_item_quantity"><div class="invoice-head text-right item-qty">Qty.</div></div><div class="col-md-4 col-sm-4 col-xs-4" data-id="checkbox_item_total"><div class="invoice-head pull-right item-total gift_receipt_element"> Total</div></div></div></th></tr> </thead> <tbody data-line="1" data-sale-id="43" data-item-id="5" data-item-name="Burger food" data-item-qty="1.0000000000" data-item-price="33" data-item-total="33" data-item-class="item"><tr class="invoice-item-details"> <td class="invoice-table-content"> <div class="row receipt-row-item-holder"><div class="col-md-12 col-sm-12 col-xs-12"><div class="invoice-content invoice-con"> <div class="invoice-content-heading"  data-id="checkbox_item_name" > Burger food </div><div class="invoice-desc" data-id="checkbox_element_variation_name">variant name</div> <div class="invoice-desc" data-id="checkbox_element_description"> description</div><div class="invoice-desc" data-id="checkbox_element_item_serialnumber">sn0021212312</div><div class="invoice-desc" data-id="checkbox_custom_fields_to_display">item custom field</div><div class="invoice-desc" data-id="checkbox_element_item_kit_info_name">item kit name</div><div class="invoice-desc" data-id="checkbox_element_item_kit_custom_fields_to_display">item kit custom field</div><div class="invoice-desc" data-id="checkbox_element_discount">discount </div> </div></div><div class="col-md-4 col-sm-4 col-xs-4 gift_receipt_element"><div class="invoice-content item-price text-right">$33.00 </div></div><div class="col-md-4 col-sm-4 col-xs-4 "><div class="invoice-content item-qty text-right"> 1</div></div><div class="col-md-4 col-sm-4 col-xs-4 gift_receipt_element"><div class="invoice-content item-total pull-right"> $33.00</div></div> </div> <div class="row"><div class="invoice-desc" data-id="checkbox_element_image"><?php
        echo img(array(
            'width' => ($this->config->item('show_images_on_receipt_width_percent') ? $this->config->item('show_images_on_receipt_width_percent') : '25') . '%',
            'src' => $img_logo_image,
            'style' => 'width:100px'
        ));
        ?></div></div></td></tr></tbody> <tbody data-line="0" data-sale-id="43" data-item-id="8" data-item-name="Chicken salad" data-item-qty="1.0000000000" data-item-price="38" data-item-total="38" data-item-class="item"><tr class="invoice-item-details"><td class="invoice-table-content"> <div class="row receipt-row-item-holder"><div class="col-md-12 col-sm-12 col-xs-12"><div class="invoice-content invoice-con"> <div class="invoice-content-heading" data-id="checkbox_item_name"> Chicken salad </div><div class="invoice-desc"> </div> <div class="invoice-desc"> </div> <div class="invoice-desc"> </div></div></div><div class="col-md-4 col-sm-4 col-xs-4 gift_receipt_element"><div class="invoice-content item-price text-right" data-id="checkbox_item_price" data-id="checkbox_item_total">$38.00 </div></div><div class="col-md-4 col-sm-4 col-xs-4 "><div class="invoice-content item-qty text-right" data-id="checkbox_item_quantity"> 1</div></div><div class="col-md-4 col-sm-4 col-xs-4 gift_receipt_element"><div class="invoice-content item-total pull-right"> $38.00</div></div> </div></td></tr></tbody> </table><div class="ui-resizable-handle ui-resizable-e" style="z-index: 90;"></div><div class="ui-resizable-handle ui-resizable-s" style="z-index: 90;"></div><div class="ui-resizable-handle ui-resizable-se ui-icon ui-icon-gripsmall-diagonal-se" style="z-index: 90;"></div></div>';

                if (elementId == 'items_list') {
                    ui.draggable.html(item_list);
                } else {
                    if (elementId == 'barcode') {
                        $img =
                            '<br><img src="<?php echo base_url(); ?>barcode/index/svg?barcode=POS 43&amp;text=POS 43" alt="">';
                        ui.draggable[0].innerText = ui.draggable[0].innerText + $img;
                        need_resizer = true;
                    } else if (elementId == 'logo') {
                        $img = '<?php echo img(
						array(
							'src' => base_url() . $this->config->item('branding')['logo_path'],
							'width' => '50px'

						)
					); ?>';
                        ui.draggable[0].innerText = ui.draggable[0].innerText + $img;
                        need_resizer = true;
                    } else if (elementId == 'custom_logo') {
                        $img = '<?php echo img(
                        array(
                            'src' => $img_logo_image,
                            'width' => '50px'

                        )
                    ); ?>';
                        ui.draggable[0].innerText = ui.draggable[0].innerText + $img;
                        need_resizer = true;
                    }
                    if (elementId.indexOf("custom_img_") !== -1) {

                        custom_img = true;
                    } else {
                        if (need_resizer == true) {
                            ui.draggable.html(ui
                                .draggable[0].innerText + resizer);
                        } else {
                            ui.draggable.html(
                                '<div class="fw-semibold text-end text-gray-600 fs-7 w-75">' +
                                ui
                                .draggable[0].innerText + '</div>');
                        }

                    }

                }
            }


            var droppedRelativeLeft = ui.offset.left - $(this).offset().left;
            var droppedRelativeTop = ui.offset.top - $(this).offset().top;
            var width = $(this).data('current_width');
            var height = $(this).data('current_height');
            // if(!custom_img && !resizer){
            // 	width = 'fit-content';
            // }

            // Append the dragged item to the drop zone
            ui.draggable.appendTo(this).css({
                top: droppedRelativeTop + 'px',
                left: droppedRelativeLeft + 'px',
                position: 'absolute',
                width: width,
                height: height,
            });
            ui.draggable.appendTo(this).attr('data-left', droppedRelativeLeft + 'px');
            ui.draggable.appendTo(this).attr('data-top', droppedRelativeTop + 'px');

            ui.draggable.appendTo(this).css({
                    top: droppedRelativeTop + 'px',
                    left: droppedRelativeLeft + 'px',
                    position: 'absolute',
                    width: width,
                    height: height,
                }).attr({
                    'data-left': droppedRelativeLeft + 'px',
                    'data-top': droppedRelativeTop + 'px'
                }) // Adding a new class
                .removeClass(
                    'd-flex align-items-center my-1 py-3 bg-light  rounded-1 '
                ); // Removing an old class





        }
    });



});

$(document).on("mouseup", ".draggable", function() {

    var elem = $(this),
        id = elem.attr('id'),
        desc = elem.attr('data-desc'),
        pos = elem.position();
    elem.attr('data-left', pos.left + 'px');
    elem.attr('data-top', pos.top + 'px');
    // console.log('Left: ' + pos.left + '; Top:' + pos.top);

});

function save() {
    pos = [];
    checks = [];
    $(".page-one .draggable").each(function() {

        var elem = $(this),
            id = elem.attr('id');

        newleft = (elem.attr('data-left')) ? elem.attr('data-left') : '0px';
        newtop = (elem.attr('data-top')) ? elem.attr('data-top') : '0px';

        newsize = (elem.attr('data-current_size')) ? elem.attr('data-current_size') : '11px';
        newweight = (elem.attr('data-current_weight')) ? elem.attr('data-current_weight') : '400';
        newcolor = (elem.attr('data-current_color')) ? elem.attr('data-current_color') : '#7c7676';
        // console.log('newcolor', newcolor);

        newtype = (elem.attr('data-type')) ? elem.attr('data-type') : '';


        display = elem.css('display');

        if (display === 'none') {
            var display = $(".page-two #" + id).css('display');
            if (display === 'none') {
                var display = $(".page-three #" + id).css('display');
                if (display != 'none') {
                    newleft = ($(".page-three #" + id).attr('data-left')) ? $(".page-three #" + id).attr(
                        'data-left') : '0px';
                    newtop = ($(".page-three #" + id).attr('data-top')) ? $(".page-three #" + id).attr(
                        'data-top') : '0px';
                    newtype = ($(".page-three #" + id).attr('data-type')) ? $(".page-three #" + id).attr(
                        'data-type') : '';
                }
            } else {
                newleft = ($(".page-two #" + id).attr('data-left')) ? $(".page-two #" + id).attr('data-left') :
                    '0px';
                newtop = ($(".page-two #" + id).attr('data-top')) ? $(".page-two #" + id).attr('data-top') :
                    '0px';
                newtype = ($(".page-two #" + id).attr('data-type')) ? $(".page-two #" + id).attr('data-type') :
                    '';
            }
        }




        newwidth = '0px';
        newheight = '0px';
        pos.push({
            'id': id,
            'newleft': newleft,
            'newtop': newtop,
            'newtype': newtype,
            'newwidth': newwidth,
            'newheight': newheight,
            'newsize': newsize,
            'newweight': newweight,
            'newcolor': newcolor,
            'display': display
        })
        console.log({
            'id': id,
            'newleft': newleft,
            'newtop': newtop,
            'newtype': newtype,
            'newwidth': newwidth,
            'newheight': newheight,
            'display': display
        });

    })
    $(" .page-one .resize").each(function() {
        // console.log("here");
        var elem = $(this),
            id = elem.attr('id');
        // console.log(id);

        newsize = (elem.attr('data-current_size')) ? elem.attr('data-current_size') : '11px';
        newweight = (elem.attr('data-current_weight')) ? elem.attr('data-current_weight') : '400';
        newleft = (elem.attr('data-left')) ? elem.attr('data-left') : '0px';
        newtop = (elem.attr('data-top')) ? elem.attr('data-top') : '0px';
        newtype = (elem.attr('data-type')) ? elem.attr('data-type') : '';
        newwidth = (elem.attr('data-current_width')) ? elem.attr('data-current_width') : '0px';
        newheight = (elem.attr('data-current_height')) ? elem.attr('data-current_height') : '0px';

        pos.push({
            'id': id,
            'newleft': newleft,
            'newtop': newtop,
            'newtype': newtype,
            'newwidth': newwidth,
            'newheight': newheight,
            'newsize': newsize,
            'newheight': newheight,
            display: elem.css('display'),
        })
        // console.log({
        //     'id': id,
        //     'newleft': newleft,
        //     'newtop': newtop,
        //     'newtype': newtype,
        //     'newwidth': newwidth,
        //     'newheight': newheight,
        //     display: elem.css('display'),
        // });
    })
    $(".save_checkbox ").each(function() {
        if ($(this).is(':checked')) {
            checks.push($(this).attr('id'));
        }
    });

    $.ajax({
        type: 'POST',
        url: '<?php echo site_url("Receipt/update_receipt"); ?>',
        data: {
            'tables': JSON.stringify(pos),
            'checks': JSON.stringify(checks),
            'receipt': '<?php echo $receipt['id']; ?>',
            'background_image_id': $('#background_image_id').val(),
            'first_page_items': $('#first_page_items').val(),
            'other_page_items': $('#other_page_items').val(),
            'table_image_position': $('#table_image_position').val(),
            'table_image_size': $('#table_image_size').val(),
            'table_element_order': $('#table_element_order').val(),
			'tbl_all_borders': $('.tbl_all_borders').attr('data-is_active'),
			'tbl_horzontal_borders': $('.tbl_horzontal_borders').attr('data-is_active'),
			'tbl_vertical_borders': $('.tbl_vertical_borders').attr('data-is_active'),
			'tbl_header_bg': $('.tbl_header_bg').attr('data-is_active'),

        },
        success: function(result) {
            show_feedback('success', <?php echo json_encode(lang('success')); ?>,
                <?php echo json_encode(lang('success')); ?>);
        }
    })

}

function hide_show_label(cl) {
    if ($('#' + cl).is(':checked')) {
        $('.' + cl).show();
    } else {
        $('.' + cl).hide();
    }
}

function close_popover() {
    $('.popover').popover('hide');
}

function save_custom_label() {
    var custom_label_id = $('#custom_label_id').val();
    if (custom_label_id != '') {
        $.ajax({
            type: 'POST',
            url: '<?php echo site_url("Receipt/add_custom_label"); ?>',
            data: {
                'custom_label_id': custom_label_id,
                'receipt': '<?php echo $receipt['id']; ?>'
            },
            success: function(result) {

                var modifiedString = custom_label_id.toLowerCase().replace(/ /g, '_');

                // Remove non-alphanumeric characters except underscores
                modifiedString = modifiedString.replace(/[^a-zA-Z0-9_]/g, '');


                $content_header = '<div class="draggable already_hidden header-' + modifiedString +
                    ' ui-draggable ui-draggable-handle" style="position: absolute;   text-wrap:nowrap;  font-weight:800; font-size:27px; color:#925624; width:auto;height:auto; text-wrap:nowrap; left:0px; top:0px; display:none;  " data-left="0px" data-top="0px" data-current_width="auto" data-current_height="auto" data-current_size="27px" data-current_weight="800" data-current_color="#925624" id="header-' +
                    modifiedString + '"> ' + custom_label_id + '</div>';
                $content_body = '<div class="draggable already_hidden body-' + modifiedString +
                    ' ui-draggable ui-draggable-handle" style="position: absolute;   text-wrap:nowrap;  font-weight:800; font-size:27px; color:#925624; width:auto;height:auto; text-wrap:nowrap; left:0px; top:0px; display:none;  " data-left="0px" data-top="0px" data-current_width="auto" data-current_height="auto" data-current_size="27px" data-current_weight="800" data-current_color="#925624" id="body-' +
                    modifiedString + '"> ' + custom_label_id + '</div>';
                $content_footer = '<div class="draggable already_hidden footer-' + modifiedString +
                    ' ui-draggable ui-draggable-handle" style="position: absolute;   text-wrap:nowrap;  font-weight:800; font-size:27px; color:#925624; width:auto;height:auto; text-wrap:nowrap; left:0px; top:0px; display:none;  " data-left="0px" data-top="0px" data-current_width="auto" data-current_height="auto" data-current_size="27px" data-current_weight="800" data-current_color="#925624" id="footer-' +
                    modifiedString + '"> ' + custom_label_id + '</div>';
                $('.page_header').prepend($content_header);

                $('.page_body').prepend($content_body);

                $('.page_footer').prepend($content_footer);

                $('#items-drag').prepend(result);
                show_feedback('success', <?php echo json_encode(lang('success')); ?>,
                    <?php echo json_encode(lang('success')); ?>);
                $('[data-toggle="popover"]').popover(); // Initialize all popovers

                // Stop propagation for the popover trigger
                $('[data-toggle="popover"]').on('click', function(e) {



                    e.stopPropagation();

                });

                // Close popover on clicking outside
                $(document).on('click', function(e) {

                    if (!$(e.target).is(':checkbox') && !$(e.target).parent().hasClass(
                            'custom_label_body')) {
                        $('[data-toggle="popover"]').popover('hide');
                    }
                });

                // Close popover on clicking inside the popover body
                $('.popover').on('click', '.popover-body', function() {

                    if (!$(e.target).is(':checkbox') && !$(this).hasClass('custom_label_body')) {
                        $('[data-toggle="popover"]').popover('hide');
                    }
                });

                $(".draggable").draggable({
                    revert: "invalid",
                    containment: "parent", // Limit movement within the specified boundary.
                    start: function(event, ui) {
                        // var elementId = ui.helper.attr('id');
                        // localStorage.setItem('draggedHTML-'+$(this).parent().attr('id')+'-' + elementId, ui.helper[0].innerHTML);
                        $(this).draggable('option', 'revert', 'invalid');
                        $(this).css({
                            'border': '3px dotted black'
                        });
                    },
                    stop: function(event, ui) {
                        $(this).css({
                            'border': 'none'
                        });
                    }
                });
                $(".resize").draggable({
                    revert: "invalid",
                    containment: "parent", // Limit movement within the specified boundary.
                    handle: ".drag-handle",
                    start: function(event, ui) {
                        $(this).draggable('option', 'revert', 'invalid');
                        $(this).css({
                            'border': '3px dotted black'
                        });
                    },
                    stop: function(event, ui) {
                        $(this).css({
                            'border': 'none'
                        });
                    }
                }).resizable({
                    handles: 'e', //east
                    start: function(event, ui) {
                        // console.log("resizelssd");
                    },
                    stop: function(event, ui) {
                        $(this).attr('data-current_width', ui.size.width);
                        $(this).attr('data-current_height', ui.size.height);
                    }
                });


                $(".page_header, .page_body , .page_footer ").droppable({
                    accept: ".draggable , .resize",
                    drop: function(event, ui) {

                        var elementId = ui.draggable.attr('id');

                        // console.log('elementId', elementId);



                        var droppedRelativeLeft = ui.offset.left - $(this).offset().left;
                        var droppedRelativeTop = ui.offset.top - $(this).offset().top;
                        var width = $(this).data('current_width');
                        var height = $(this).data('current_height');
                        // if(!custom_img && !resizer){
                        // 	width = 'fit-content';
                        // }

                        // Append the dragged item to the drop zone
                        ui.draggable.appendTo(this).css({
                            top: droppedRelativeTop + 'px',
                            left: droppedRelativeLeft + 'px',
                            position: 'absolute',
                            width: width,
                            height: height,
                        });
                        ui.draggable.appendTo(this).attr('data-left', droppedRelativeLeft +
                            'px');
                        ui.draggable.appendTo(this).attr('data-top', droppedRelativeTop + 'px');

                        ui.draggable.appendTo(this).css({
                            top: droppedRelativeTop + 'px',
                            left: droppedRelativeLeft + 'px',
                            position: 'absolute',
                            width: width,
                            height: height,
                        }).attr({
                            'data-left': droppedRelativeLeft + 'px',
                            'data-top': droppedRelativeTop + 'px'
                        }); // Removing an old class





                    }
                });

                close_popover();

            }
        })
    } else {
        show_feedback('error', <?php echo json_encode(lang('please enter label name')); ?>,
            <?php echo json_encode(lang('error')); ?>);
    }

}



$('#filterForm').on('submit', function(e) {
    //     e.preventDefault();

    //     var formData = new FormData(this); // 'this' refers to the form element
    // // console.log(formData);
    // //AJAX request
    // $.ajax({
    // 	url: '<?php echo site_url("Receipt/update_receipt_detail"); ?>',
    // 	type: 'POST',
    // 	data: formData,
    // 	success: function(response) {
    // 		// Handle success
    // 		show_feedback('success', <?php echo json_encode(lang('success')); ?>, <?php echo json_encode(lang('success')); ?>);
    // 	},
    // 	error: function(xhr, status, error) {
    // 		// Handle errors
    // 		console.error('Form submission failed:', error);
    // 	}
    // });
});

$(document).ready(function() {
    // Add click event listener to menu-link elements
    $("#menu-container").on("click", ".menu-link", function() {
        if (!$(this).hasClass("redirect-link")) {
            if ($(this).hasClass("not-link")) {
                return; // Exit without doing anything
            }
            // Remove 'active' class from all menu-link siblings
            $(this).siblings().removeClass("active");

            // Add 'active' class to the clicked menu-link
            $(this).addClass("active");

            // Get the data-id of the clicked menu-link
            var relatedId = $(this).data("id");

            // Hide all menu-card divs by adding 'd-none'
            $(".menu-card").addClass("d-none");

            // Show the menu-card with ID matching data-id
            $("#" + relatedId).removeClass("d-none");
            // console.log("it should not redirect")
        } else {
            window.location.href = $(this).attr('href');
        }

    });

});

function show_detail_listing_table() {
    $(".menu-card").addClass("d-none");
    $("#detail_listing_table").removeClass("d-none");
}
</script>

<?php $this->load->view("partial/footer"); ?>