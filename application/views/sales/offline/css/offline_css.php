<style>
    .w-70px {
        width: 70px !important;
    }

    #kt_app_sidebar_toggle .svg-icon {
        margin: 0 auto;
        border-radius: 50%;
        border: 1px solid;
    }
    .svg-icon.svg-icon-muted {
        color: var(--kt-text-gray-600);
    }
    .pos-sidebar {
        z-index: 100000 !important;
    }

    .pos-sidebar .menu-link {
        height: 70px;
        border: 1px solid rgb(246, 248, 252);
        display: flex;
        justify-content: center;
        width: 70px;
        box-shadow: 0px 0px 1px 1px rgb(0 0 0 / 10%);
        padding: 0px !important;
    }
    .pos-sidebar .menu-item {
        padding: 0px !important;
    }

    div#kt_app_sidebar_toggle {
        height: 70px;
        border: 1px solid rgb(246, 248, 252);
        box-shadow: 0px 0px 1px 1px rgb(0 0 0 / 10%);
    }

    .top-left-pos .register-box {
        width: calc(100% - 80px);
        margin-left: 5px;
    }
    .sale-grid-big-wrapper-parent{
        width: calc(100% - 80px);
    }

    html[data-theme='light'] .register-box {
        background: white !important;
        color: black !important;
    }
    
    .pos_bg_dark{
        background-color: #eef1f5 !important;
    }
  .bg-primary{
    background-color: var(--kt-primary) !important;
  }
  .border-radius-left{
    border-radius: 5px 0px 0px 5px !important;
    border-top-left-radius: 5px !important;
    border-bottom-left-radius: 5px !important;
  }
  .input-group .border-radius-left {
    border-top-left-radius: 5px !important;
    border-bottom-left-radius: 5px !important;
}


  .border-radius-right{
    border-radius: 0px 5px 5px 0px !important;
    border-top-right-radius: 5px !important;
    border-bottom-right-radius: 5px !important;
   

  }
 
  .bg-primary:hover{
    background-color: #383fcf  !important;
  }
  .btn-check:active+.btn.btn-active-color-primary, .btn-check:checked+.btn.btn-active-color-primary, .btn.btn-active-color-primary.active, .btn.btn-active-color-primary.show, .btn.btn-active-color-primary:active:not(.btn-active), .btn.btn-active-color-primary:focus:not(.btn-active), .btn.btn-active-color-primary:hover:not(.btn-active), .show>.btn.btn-active-color-primary {
        color: #ffffff;
    }
    .text-hover-primary:hover {
        transition: color .2s ease;
        color: var(--kt-text-light) !important;
    }
    .text-hover-primary:hover i {
        transition: color .2s ease;
        color: var(--kt-text-light) !important;
    }
    .h-42px {
        height: 42px !important;
    }
    .h-43px {
        height: 43px !important;
    }
    .align-item-center {
        align-items: center !important;;
    }
    .d-inline-flex{
        display: inline-flex !important;
    }
    

    span#cancel_sale_button {
        cursor: pointer;
    }
    #pos_footer{
        box-shadow: 0px -2px 1px 1px rgb(0 0 0 / 10%)
    }
    #customer {
        width: 94.4%  !important;
    }

    .order_detail_margin{
        margin: 4px 6px 0px 2px !important;
    }
    .vertical {
         transform: rotate(90deg);
    }
    .vertical-center{
        display: grid;
        place-items: center;
    }
    .vertical-align{
        vertical-align: middle;
    }
    .text-hover-none:hover{
        text-decoration: none !important;
        color: inherit !important;
    }

    .text-muted.fs-7.fw-bold {
    margin-top: 2px;
}

.text-black{
    color: black !important;
}

.top-55 {
    top: 55%;
}
.mt-minus-4{
    margin-top: -4px;
} 

i.fonticon-content-marketing{
    background: unset  !important;
    border: unset  !important;
}

.flex-direction-column{
    flex-direction: column;
}
.bg-unset{
    background: unset !important;
}
div#kt_app_layout_builder_header {
    border-bottom: 1px solid black !important;
}

#footers{
    height: 0px !important;
    padding: 0px;
    margin: 0px;
}
.table td:first-child, .table th:first-child, .table tr:first-child {
    padding-left: 5px;
}


.dummy-card {
    background: #f8f9fa;
    border-radius: 8px;
    padding: 10px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.dummy-image {
    width: 100%;
    height: 70px;
    background: linear-gradient(90deg, #e0e0e0 25%, #f8f8f8 50%, #e0e0e0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
    border-radius: 8px;
}

.dummy-text {
    width: 80%;
    height: 10px;
    background: linear-gradient(90deg, #e0e0e0 25%, #f8f8f8 50%, #e0e0e0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
    margin: 10px auto;
    border-radius: 4px;
}

.dummy-text.short {
    width: 50%;
}

@keyframes loading {
    0% {
        background-position: 200% 0;
    }
    100% {
        background-position: -200% 0;
    }
}
</style>