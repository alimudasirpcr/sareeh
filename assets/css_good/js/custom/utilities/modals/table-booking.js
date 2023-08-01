"use strict";
var KTCreateAccount = function() {
    var e, t, i, o, r, s, n = [];
    return {
        init: function() {
            (e = document.querySelector("#kt_modal_create_account")) && new bootstrap.Modal(e), (t = document.querySelector("#kt_create_account_stepper")) && (i = t.querySelector("#kt_create_account_form"), o = t.querySelector('[data-kt-stepper-action="submit"]'), r = t.querySelector('[data-kt-stepper-action="next"]'), (s = new KTStepper(t)).on("kt.stepper.changed", (function(e) {
                4 === s.getCurrentStepIndex() ? (o.classList.remove("d-none"), o.classList.add("d-inline-block"), r.classList.add("d-none")) : 5 === s.getCurrentStepIndex() ? (o.classList.add("d-none"), r.classList.add("d-none")) : (o.classList.remove("d-inline-block"), o.classList.remove("d-none"), r.classList.remove("d-none"))
            })), s.on("kt.stepper.next", (function(e) {
                console.log("stepper.next");
                var t = n[e.getCurrentStepIndex() - 1];
                t ? t.validate().then((function(t) {
                    console.log("validated!"), "Valid" == t ? (e.goNext(), KTUtil.scrollTop()) : Swal.fire({
                        text: "Sorry, looks like there are some errors detected, please try again.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok, got it!",
                        customClass: {
                            confirmButton: "btn btn-light"
                        }
                    }).then((function() {
                        KTUtil.scrollTop()
                    }))
                })) : (e.goNext(), KTUtil.scrollTop())
            })), s.on("kt.stepper.previous", (function(e) {
                console.log("stepper.previous"), e.goPrevious(), KTUtil.scrollTop()
            })), n.push(FormValidation.formValidation(i, {
                fields: {
                    account_type: {
                        validators: {
                            notEmpty: {
                                message: "Account type is required"
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger,
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: ""
                    })
                }
            })), n.push(FormValidation.formValidation(i, {
                fields: {
                    account_team_size: {
                        validators: {
                            notEmpty: {
                                message: "Time size is required"
                            }
                        }
                    },
                    account_name: {
                        validators: {
                            notEmpty: {
                                message: "Account name is required"
                            }
                        }
                    },
                    account_plan: {
                        validators: {
                            notEmpty: {
                                message: "Account plan is required"
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger,
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: ""
                    })
                }
            })), n.push(FormValidation.formValidation(i, {
                fields: {
                    first_name: {
                        validators: {
                            notEmpty: {
                                message: "First  name is required"
                            }
                        }
                    },
                    last_name: {
                        validators: {
                            notEmpty: {
								message: "Last  name is required"
                            }
                        }
                    },
                    phone: {
                        validators: {
                            notEmpty: {
                                message: "Phone is required"
                            }
                        }
                    },
                    address: {
                        validators: {
                            notEmpty: {
                                message: "Address  is required"
                            }
                        }
                    },
                    email: {
                        validators: {
                            notEmpty: {
                                message: "Email is required"
                            },
                            emailAddress: {
                                message: "The value is not a valid email address"
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger,
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: ""
                    })
                }
            })), n.push(FormValidation.formValidation(i, {
                fields: {
                    card_name: {
                        validators: {
                            notEmpty: {
                                message: "Name on card is required"
                            }
                        }
                    },
                    card_number: {
                        validators: {
                            notEmpty: {
                                message: "Card member is required"
                            },
                            creditCard: {
                                message: "Card number is not valid"
                            }
                        }
                    },
                    card_expiry_month: {
                        validators: {
                            notEmpty: {
                                message: "Month is required"
                            }
                        }
                    },
                    card_expiry_year: {
                        validators: {
                            notEmpty: {
                                message: "Year is required"
                            }
                        }
                    },
                    card_cvv: {
                        validators: {
                            notEmpty: {
                                message: "CVV is required"
                            },
                            digits: {
                                message: "CVV must contain only digits"
                            },
                            stringLength: {
                                min: 3,
                                max: 4,
                                message: "CVV must contain 3 to 4 digits only"
                            }
                        }
                    }
                },
                plugins: {
                    trigger: new FormValidation.plugins.Trigger,
                    bootstrap: new FormValidation.plugins.Bootstrap5({
                        rowSelector: ".fv-row",
                        eleInvalidClass: "",
                        eleValidClass: ""
                    })
                }
            })), o.addEventListener("click", (function(e) {
                n[3].validate().then((function(t) {
                    console.log("validated!"), "Valid" == t ? (e.preventDefault(), o.disabled = !0, o.setAttribute("data-kt-indicator", "on"),    
                    

                    axios.post($('#kt_create_account_form').attr('action'), new FormData($('#kt_create_account_form')[0])  , {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }).then(function(response) {
                        // console.log(response)
                     
                        localStorage.setItem("email", $('#email').val());

                        if(response.data.status==true){
                           // $('#html_here').html(response.data.msg);
                            Swal.fire({
                           
                                html: response.data.msg,
                                icon: "success",
                                buttonsStyling: !1,
                                confirmButtonText: "Ok,Got it!",
                                customClass: {
                                    confirmButton: "btn btn-light"
                                }
                            }),
                            s.goNext(),o.removeAttribute("data-kt-indicator"), o.disabled = !1, i.hasAttribute("data-kt-redirect-url")
                        }else{
                            Swal.fire({
                               
                                html: response.data.msg,
                                icon: "error",
                                width:"60%",
                                buttonsStyling: !1,
                                cconfirmButtonText: "Ok, Got it!",
                                customClass: {
                                    confirmButton: "btn btn-light"
                                }
                            }),o.removeAttribute("data-kt-indicator"), o.disabled = !1, i.hasAttribute("data-kt-redirect-url")
                        }
                        
                    })) : Swal.fire({
                        text: "Sorr, Some error detected , Pleas try gain.",
                        icon: "error",
                        buttonsStyling: !1,
                        confirmButtonText: "Ok,Got it!",
                        customClass: {
                            confirmButton: "btn btn-light"
                        }
                    }).then((function() {
                        KTUtil.scrollTop()
                    }))
                }))
            })), $(i.querySelector('[name="card_expiry_month"]')).on("change", (function() {
                n[3].revalidateField("card_expiry_month")
            })), $(i.querySelector('[name="card_expiry_year"]')).on("change", (function() {
                n[3].revalidateField("card_expiry_year")
            })), $(i.querySelector('[name="business_type"]')).on("change", (function() {
                n[2].revalidateField("business_type")
            })))
        }
    }
}();
KTUtil.onDOMContentLoaded((function() {
    KTCreateAccount.init()
}));