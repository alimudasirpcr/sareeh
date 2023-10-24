! function(e, t) {
    "use strict";
    "object" == typeof module && "object" == typeof module.exports ? module.exports = e.document ? t(e, !0) : function(e) {
        if (!e.document) throw new Error("jQuery requires a window with a document");
        return t(e)
    } : t(e)
}("undefined" != typeof window ? window : this, (function(e, t) {
    "use strict";
    var n = [],
        i = Object.getPrototypeOf,
        a = n.slice,
        r = n.flat ? function(e) {
            return n.flat.call(e)
        } : function(e) {
            return n.concat.apply([], e)
        },
        s = n.push,
        o = n.indexOf,
        l = {},
        c = l.toString,
        u = l.hasOwnProperty,
        d = u.toString,
        h = d.call(Object),
        f = {},
        p = function(e) {
            return "function" == typeof e && "number" != typeof e.nodeType && "function" != typeof e.item
        },
        g = function(e) {
            return null != e && e === e.window
        },
        m = e.document,
        v = {
            type: !0,
            src: !0,
            nonce: !0,
            noModule: !0
        };

    function y(e, t, n) {
        var i, a, r = (n = n || m).createElement("script");
        if (r.text = e, t)
            for (i in v)(a = t[i] || t.getAttribute && t.getAttribute(i)) && r.setAttribute(i, a);
        n.head.appendChild(r).parentNode.removeChild(r)
    }

    function b(e) {
        return null == e ? e + "" : "object" == typeof e || "function" == typeof e ? l[c.call(e)] || "object" : typeof e
    }
    var x = "3.6.0",
        _ = function(e, t) {
            return new _.fn.init(e, t)
        };

    function w(e) {
        var t = !!e && "length" in e && e.length,
            n = b(e);
        return !p(e) && !g(e) && ("array" === n || 0 === t || "number" == typeof t && t > 0 && t - 1 in e)
    }
    _.fn = _.prototype = {
        jquery: x,
        constructor: _,
        length: 0,
        toArray: function() {
            return a.call(this)
        },
        get: function(e) {
            return null == e ? a.call(this) : e < 0 ? this[e + this.length] : this[e]
        },
        pushStack: function(e) {
            var t = _.merge(this.constructor(), e);
            return t.prevObject = this, t
        },
        each: function(e) {
            return _.each(this, e)
        },
        map: function(e) {
            return this.pushStack(_.map(this, (function(t, n) {
                return e.call(t, n, t)
            })))
        },
        slice: function() {
            return this.pushStack(a.apply(this, arguments))
        },
        first: function() {
            return this.eq(0)
        },
        last: function() {
            return this.eq(-1)
        },
        even: function() {
            return this.pushStack(_.grep(this, (function(e, t) {
                return (t + 1) % 2
            })))
        },
        odd: function() {
            return this.pushStack(_.grep(this, (function(e, t) {
                return t % 2
            })))
        },
        eq: function(e) {
            var t = this.length,
                n = +e + (e < 0 ? t : 0);
            return this.pushStack(n >= 0 && n < t ? [this[n]] : [])
        },
        end: function() {
            return this.prevObject || this.constructor()
        },
        push: s,
        sort: n.sort,
        splice: n.splice
    }, _.extend = _.fn.extend = function() {
        var e, t, n, i, a, r, s = arguments[0] || {},
            o = 1,
            l = arguments.length,
            c = !1;
        for ("boolean" == typeof s && (c = s, s = arguments[o] || {}, o++), "object" == typeof s || p(s) || (s = {}), o === l && (s = this, o--); o < l; o++)
            if (null != (e = arguments[o]))
                for (t in e) i = e[t], "__proto__" !== t && s !== i && (c && i && (_.isPlainObject(i) || (a = Array.isArray(i))) ? (n = s[t], r = a && !Array.isArray(n) ? [] : a || _.isPlainObject(n) ? n : {}, a = !1, s[t] = _.extend(c, r, i)) : void 0 !== i && (s[t] = i));
        return s
    }, _.extend({
        expando: "jQuery" + (x + Math.random()).replace(/\D/g, ""),
        isReady: !0,
        error: function(e) {
            throw new Error(e)
        },
        noop: function() {},
        isPlainObject: function(e) {
            var t, n;
            return !(!e || "[object Object]" !== c.call(e)) && (!(t = i(e)) || "function" == typeof(n = u.call(t, "constructor") && t.constructor) && d.call(n) === h)
        },
        isEmptyObject: function(e) {
            var t;
            for (t in e) return !1;
            return !0
        },
        globalEval: function(e, t, n) {
            y(e, {
                nonce: t && t.nonce
            }, n)
        },
        each: function(e, t) {
            var n, i = 0;
            if (w(e))
                for (n = e.length; i < n && !1 !== t.call(e[i], i, e[i]); i++);
            else
                for (i in e)
                    if (!1 === t.call(e[i], i, e[i])) break;
            return e
        },
        makeArray: function(e, t) {
            var n = t || [];
            return null != e && (w(Object(e)) ? _.merge(n, "string" == typeof e ? [e] : e) : s.call(n, e)), n
        },
        inArray: function(e, t, n) {
            return null == t ? -1 : o.call(t, e, n)
        },
        merge: function(e, t) {
            for (var n = +t.length, i = 0, a = e.length; i < n; i++) e[a++] = t[i];
            return e.length = a, e
        },
        grep: function(e, t, n) {
            for (var i = [], a = 0, r = e.length, s = !n; a < r; a++) !t(e[a], a) !== s && i.push(e[a]);
            return i
        },
        map: function(e, t, n) {
            var i, a, s = 0,
                o = [];
            if (w(e))
                for (i = e.length; s < i; s++) null != (a = t(e[s], s, n)) && o.push(a);
            else
                for (s in e) null != (a = t(e[s], s, n)) && o.push(a);
            return r(o)
        },
        guid: 1,
        support: f
    }), "function" == typeof Symbol && (_.fn[Symbol.iterator] = n[Symbol.iterator]), _.each("Boolean Number String Function Array Date RegExp Object Error Symbol".split(" "), (function(e, t) {
        l["[object " + t + "]"] = t.toLowerCase()
    }));
    var k =
        /*!
         * Sizzle CSS Selector Engine v2.3.6
         * https://sizzlejs.com/
         *
         * Copyright JS Foundation and other contributors
         * Released under the MIT license
         * https://js.foundation/
         *
         * Date: 2021-02-16
         */
        function(e) {
            var t, n, i, a, r, s, o, l, c, u, d, h, f, p, g, m, v, y, b, x = "sizzle" + 1 * new Date,
                _ = e.document,
                w = 0,
                k = 0,
                M = le(),
                L = le(),
                S = le(),
                A = le(),
                T = function(e, t) {
                    return e === t && (d = !0), 0
                },
                C = {}.hasOwnProperty,
                D = [],
                E = D.pop,
                O = D.push,
                P = D.push,
                Y = D.slice,
                I = function(e, t) {
                    for (var n = 0, i = e.length; n < i; n++)
                        if (e[n] === t) return n;
                    return -1
                },
                j = "checked|selected|async|autofocus|autoplay|controls|defer|disabled|hidden|ismap|loop|multiple|open|readonly|required|scoped",
                N = "[\\x20\\t\\r\\n\\f]",
                H = "(?:\\\\[\\da-fA-F]{1,6}[\\x20\\t\\r\\n\\f]?|\\\\[^\\r\\n\\f]|[\\w-]|[^\0-\\x7f])+",
                F = "\\[[\\x20\\t\\r\\n\\f]*(" + H + ")(?:" + N + "*([*^$|!~]?=)" + N + "*(?:'((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\"|(" + H + "))|)" + N + "*\\]",
                R = ":(" + H + ")(?:\\((('((?:\\\\.|[^\\\\'])*)'|\"((?:\\\\.|[^\\\\\"])*)\")|((?:\\\\.|[^\\\\()[\\]]|" + F + ")*)|.*)\\)|)",
                z = new RegExp(N + "+", "g"),
                B = new RegExp("^[\\x20\\t\\r\\n\\f]+|((?:^|[^\\\\])(?:\\\\.)*)[\\x20\\t\\r\\n\\f]+$", "g"),
                W = new RegExp("^[\\x20\\t\\r\\n\\f]*,[\\x20\\t\\r\\n\\f]*"),
                V = new RegExp("^[\\x20\\t\\r\\n\\f]*([>+~]|[\\x20\\t\\r\\n\\f])[\\x20\\t\\r\\n\\f]*"),
                q = new RegExp(N + "|>"),
                X = new RegExp(R),
                U = new RegExp("^" + H + "$"),
                $ = {
                    ID: new RegExp("^#(" + H + ")"),
                    CLASS: new RegExp("^\\.(" + H + ")"),
                    TAG: new RegExp("^(" + H + "|[*])"),
                    ATTR: new RegExp("^" + F),
                    PSEUDO: new RegExp("^" + R),
                    CHILD: new RegExp("^:(only|first|last|nth|nth-last)-(child|of-type)(?:\\([\\x20\\t\\r\\n\\f]*(even|odd|(([+-]|)(\\d*)n|)[\\x20\\t\\r\\n\\f]*(?:([+-]|)[\\x20\\t\\r\\n\\f]*(\\d+)|))[\\x20\\t\\r\\n\\f]*\\)|)", "i"),
                    bool: new RegExp("^(?:" + j + ")$", "i"),
                    needsContext: new RegExp("^[\\x20\\t\\r\\n\\f]*[>+~]|:(even|odd|eq|gt|lt|nth|first|last)(?:\\([\\x20\\t\\r\\n\\f]*((?:-\\d)?\\d*)[\\x20\\t\\r\\n\\f]*\\)|)(?=[^-]|$)", "i")
                },
                G = /HTML$/i,
                Z = /^(?:input|select|textarea|button)$/i,
                K = /^h\d$/i,
                J = /^[^{]+\{\s*\[native \w/,
                Q = /^(?:#([\w-]+)|(\w+)|\.([\w-]+))$/,
                ee = /[+~]/,
                te = new RegExp("\\\\[\\da-fA-F]{1,6}[\\x20\\t\\r\\n\\f]?|\\\\([^\\r\\n\\f])", "g"),
                ne = function(e, t) {
                    var n = "0x" + e.slice(1) - 65536;
                    return t || (n < 0 ? String.fromCharCode(n + 65536) : String.fromCharCode(n >> 10 | 55296, 1023 & n | 56320))
                },
                ie = /([\0-\x1f\x7f]|^-?\d)|^-$|[^\0-\x1f\x7f-\uFFFF\w-]/g,
                ae = function(e, t) {
                    return t ? "\0" === e ? "�" : e.slice(0, -1) + "\\" + e.charCodeAt(e.length - 1).toString(16) + " " : "\\" + e
                },
                re = function() {
                    h()
                },
                se = xe((function(e) {
                    return !0 === e.disabled && "fieldset" === e.nodeName.toLowerCase()
                }), {
                    dir: "parentNode",
                    next: "legend"
                });
            try {
                P.apply(D = Y.call(_.childNodes), _.childNodes), D[_.childNodes.length].nodeType
            } catch (e) {
                P = {
                    apply: D.length ? function(e, t) {
                        O.apply(e, Y.call(t))
                    } : function(e, t) {
                        for (var n = e.length, i = 0; e[n++] = t[i++];);
                        e.length = n - 1
                    }
                }
            }

            function oe(e, t, i, a) {
                var r, o, c, u, d, p, v, y = t && t.ownerDocument,
                    _ = t ? t.nodeType : 9;
                if (i = i || [], "string" != typeof e || !e || 1 !== _ && 9 !== _ && 11 !== _) return i;
                if (!a && (h(t), t = t || f, g)) {
                    if (11 !== _ && (d = Q.exec(e)))
                        if (r = d[1]) {
                            if (9 === _) {
                                if (!(c = t.getElementById(r))) return i;
                                if (c.id === r) return i.push(c), i
                            } else if (y && (c = y.getElementById(r)) && b(t, c) && c.id === r) return i.push(c), i
                        } else {
                            if (d[2]) return P.apply(i, t.getElementsByTagName(e)), i;
                            if ((r = d[3]) && n.getElementsByClassName && t.getElementsByClassName) return P.apply(i, t.getElementsByClassName(r)), i
                        } if (n.qsa && !A[e + " "] && (!m || !m.test(e)) && (1 !== _ || "object" !== t.nodeName.toLowerCase())) {
                        if (v = e, y = t, 1 === _ && (q.test(e) || V.test(e))) {
                            for ((y = ee.test(e) && ve(t.parentNode) || t) === t && n.scope || ((u = t.getAttribute("id")) ? u = u.replace(ie, ae) : t.setAttribute("id", u = x)), o = (p = s(e)).length; o--;) p[o] = (u ? "#" + u : ":scope") + " " + be(p[o]);
                            v = p.join(",")
                        }
                        try {
                            return P.apply(i, y.querySelectorAll(v)), i
                        } catch (t) {
                            A(e, !0)
                        } finally {
                            u === x && t.removeAttribute("id")
                        }
                    }
                }
                return l(e.replace(B, "$1"), t, i, a)
            }

            function le() {
                var e = [];
                return function t(n, a) {
                    return e.push(n + " ") > i.cacheLength && delete t[e.shift()], t[n + " "] = a
                }
            }

            function ce(e) {
                return e[x] = !0, e
            }

            function ue(e) {
                var t = f.createElement("fieldset");
                try {
                    return !!e(t)
                } catch (e) {
                    return !1
                } finally {
                    t.parentNode && t.parentNode.removeChild(t), t = null
                }
            }

            function de(e, t) {
                for (var n = e.split("|"), a = n.length; a--;) i.attrHandle[n[a]] = t
            }

            function he(e, t) {
                var n = t && e,
                    i = n && 1 === e.nodeType && 1 === t.nodeType && e.sourceIndex - t.sourceIndex;
                if (i) return i;
                if (n)
                    for (; n = n.nextSibling;)
                        if (n === t) return -1;
                return e ? 1 : -1
            }

            function fe(e) {
                return function(t) {
                    return "input" === t.nodeName.toLowerCase() && t.type === e
                }
            }

            function pe(e) {
                return function(t) {
                    var n = t.nodeName.toLowerCase();
                    return ("input" === n || "button" === n) && t.type === e
                }
            }

            function ge(e) {
                return function(t) {
                    return "form" in t ? t.parentNode && !1 === t.disabled ? "label" in t ? "label" in t.parentNode ? t.parentNode.disabled === e : t.disabled === e : t.isDisabled === e || t.isDisabled !== !e && se(t) === e : t.disabled === e : "label" in t && t.disabled === e
                }
            }

            function me(e) {
                return ce((function(t) {
                    return t = +t, ce((function(n, i) {
                        for (var a, r = e([], n.length, t), s = r.length; s--;) n[a = r[s]] && (n[a] = !(i[a] = n[a]))
                    }))
                }))
            }

            function ve(e) {
                return e && void 0 !== e.getElementsByTagName && e
            }
            for (t in n = oe.support = {}, r = oe.isXML = function(e) {
                    var t = e && e.namespaceURI,
                        n = e && (e.ownerDocument || e).documentElement;
                    return !G.test(t || n && n.nodeName || "HTML")
                }, h = oe.setDocument = function(e) {
                    var t, a, s = e ? e.ownerDocument || e : _;
                    return s != f && 9 === s.nodeType && s.documentElement ? (p = (f = s).documentElement, g = !r(f), _ != f && (a = f.defaultView) && a.top !== a && (a.addEventListener ? a.addEventListener("unload", re, !1) : a.attachEvent && a.attachEvent("onunload", re)), n.scope = ue((function(e) {
                        return p.appendChild(e).appendChild(f.createElement("div")), void 0 !== e.querySelectorAll && !e.querySelectorAll(":scope fieldset div").length
                    })), n.attributes = ue((function(e) {
                        return e.className = "i", !e.getAttribute("className")
                    })), n.getElementsByTagName = ue((function(e) {
                        return e.appendChild(f.createComment("")), !e.getElementsByTagName("*").length
                    })), n.getElementsByClassName = J.test(f.getElementsByClassName), n.getById = ue((function(e) {
                        return p.appendChild(e).id = x, !f.getElementsByName || !f.getElementsByName(x).length
                    })), n.getById ? (i.filter.ID = function(e) {
                        var t = e.replace(te, ne);
                        return function(e) {
                            return e.getAttribute("id") === t
                        }
                    }, i.find.ID = function(e, t) {
                        if (void 0 !== t.getElementById && g) {
                            var n = t.getElementById(e);
                            return n ? [n] : []
                        }
                    }) : (i.filter.ID = function(e) {
                        var t = e.replace(te, ne);
                        return function(e) {
                            var n = void 0 !== e.getAttributeNode && e.getAttributeNode("id");
                            return n && n.value === t
                        }
                    }, i.find.ID = function(e, t) {
                        if (void 0 !== t.getElementById && g) {
                            var n, i, a, r = t.getElementById(e);
                            if (r) {
                                if ((n = r.getAttributeNode("id")) && n.value === e) return [r];
                                for (a = t.getElementsByName(e), i = 0; r = a[i++];)
                                    if ((n = r.getAttributeNode("id")) && n.value === e) return [r]
                            }
                            return []
                        }
                    }), i.find.TAG = n.getElementsByTagName ? function(e, t) {
                        return void 0 !== t.getElementsByTagName ? t.getElementsByTagName(e) : n.qsa ? t.querySelectorAll(e) : void 0
                    } : function(e, t) {
                        var n, i = [],
                            a = 0,
                            r = t.getElementsByTagName(e);
                        if ("*" === e) {
                            for (; n = r[a++];) 1 === n.nodeType && i.push(n);
                            return i
                        }
                        return r
                    }, i.find.CLASS = n.getElementsByClassName && function(e, t) {
                        if (void 0 !== t.getElementsByClassName && g) return t.getElementsByClassName(e)
                    }, v = [], m = [], (n.qsa = J.test(f.querySelectorAll)) && (ue((function(e) {
                        var t;
                        p.appendChild(e).innerHTML = "<a id='" + x + "'></a><select id='" + x + "-\r\\' msallowcapture=''><option selected=''></option></select>", e.querySelectorAll("[msallowcapture^='']").length && m.push("[*^$]=[\\x20\\t\\r\\n\\f]*(?:''|\"\")"), e.querySelectorAll("[selected]").length || m.push("\\[[\\x20\\t\\r\\n\\f]*(?:value|" + j + ")"), e.querySelectorAll("[id~=" + x + "-]").length || m.push("~="), (t = f.createElement("input")).setAttribute("name", ""), e.appendChild(t), e.querySelectorAll("[name='']").length || m.push("\\[[\\x20\\t\\r\\n\\f]*name[\\x20\\t\\r\\n\\f]*=[\\x20\\t\\r\\n\\f]*(?:''|\"\")"), e.querySelectorAll(":checked").length || m.push(":checked"), e.querySelectorAll("a#" + x + "+*").length || m.push(".#.+[+~]"), e.querySelectorAll("\\\f"), m.push("[\\r\\n\\f]")
                    })), ue((function(e) {
                        e.innerHTML = "<a href='' disabled='disabled'></a><select disabled='disabled'><option/></select>";
                        var t = f.createElement("input");
                        t.setAttribute("type", "hidden"), e.appendChild(t).setAttribute("name", "D"), e.querySelectorAll("[name=d]").length && m.push("name[\\x20\\t\\r\\n\\f]*[*^$|!~]?="), 2 !== e.querySelectorAll(":enabled").length && m.push(":enabled", ":disabled"), p.appendChild(e).disabled = !0, 2 !== e.querySelectorAll(":disabled").length && m.push(":enabled", ":disabled"), e.querySelectorAll("*,:x"), m.push(",.*:")
                    }))), (n.matchesSelector = J.test(y = p.matches || p.webkitMatchesSelector || p.mozMatchesSelector || p.oMatchesSelector || p.msMatchesSelector)) && ue((function(e) {
                        n.disconnectedMatch = y.call(e, "*"), y.call(e, "[s!='']:x"), v.push("!=", R)
                    })), m = m.length && new RegExp(m.join("|")), v = v.length && new RegExp(v.join("|")), t = J.test(p.compareDocumentPosition), b = t || J.test(p.contains) ? function(e, t) {
                        var n = 9 === e.nodeType ? e.documentElement : e,
                            i = t && t.parentNode;
                        return e === i || !(!i || 1 !== i.nodeType || !(n.contains ? n.contains(i) : e.compareDocumentPosition && 16 & e.compareDocumentPosition(i)))
                    } : function(e, t) {
                        if (t)
                            for (; t = t.parentNode;)
                                if (t === e) return !0;
                        return !1
                    }, T = t ? function(e, t) {
                        if (e === t) return d = !0, 0;
                        var i = !e.compareDocumentPosition - !t.compareDocumentPosition;
                        return i || (1 & (i = (e.ownerDocument || e) == (t.ownerDocument || t) ? e.compareDocumentPosition(t) : 1) || !n.sortDetached && t.compareDocumentPosition(e) === i ? e == f || e.ownerDocument == _ && b(_, e) ? -1 : t == f || t.ownerDocument == _ && b(_, t) ? 1 : u ? I(u, e) - I(u, t) : 0 : 4 & i ? -1 : 1)
                    } : function(e, t) {
                        if (e === t) return d = !0, 0;
                        var n, i = 0,
                            a = e.parentNode,
                            r = t.parentNode,
                            s = [e],
                            o = [t];
                        if (!a || !r) return e == f ? -1 : t == f ? 1 : a ? -1 : r ? 1 : u ? I(u, e) - I(u, t) : 0;
                        if (a === r) return he(e, t);
                        for (n = e; n = n.parentNode;) s.unshift(n);
                        for (n = t; n = n.parentNode;) o.unshift(n);
                        for (; s[i] === o[i];) i++;
                        return i ? he(s[i], o[i]) : s[i] == _ ? -1 : o[i] == _ ? 1 : 0
                    }, f) : f
                }, oe.matches = function(e, t) {
                    return oe(e, null, null, t)
                }, oe.matchesSelector = function(e, t) {
                    if (h(e), n.matchesSelector && g && !A[t + " "] && (!v || !v.test(t)) && (!m || !m.test(t))) try {
                        var i = y.call(e, t);
                        if (i || n.disconnectedMatch || e.document && 11 !== e.document.nodeType) return i
                    } catch (e) {
                        A(t, !0)
                    }
                    return oe(t, f, null, [e]).length > 0
                }, oe.contains = function(e, t) {
                    return (e.ownerDocument || e) != f && h(e), b(e, t)
                }, oe.attr = function(e, t) {
                    (e.ownerDocument || e) != f && h(e);
                    var a = i.attrHandle[t.toLowerCase()],
                        r = a && C.call(i.attrHandle, t.toLowerCase()) ? a(e, t, !g) : void 0;
                    return void 0 !== r ? r : n.attributes || !g ? e.getAttribute(t) : (r = e.getAttributeNode(t)) && r.specified ? r.value : null
                }, oe.escape = function(e) {
                    return (e + "").replace(ie, ae)
                }, oe.error = function(e) {
                    throw new Error("Syntax error, unrecognized expression: " + e)
                }, oe.uniqueSort = function(e) {
                    var t, i = [],
                        a = 0,
                        r = 0;
                    if (d = !n.detectDuplicates, u = !n.sortStable && e.slice(0), e.sort(T), d) {
                        for (; t = e[r++];) t === e[r] && (a = i.push(r));
                        for (; a--;) e.splice(i[a], 1)
                    }
                    return u = null, e
                }, a = oe.getText = function(e) {
                    var t, n = "",
                        i = 0,
                        r = e.nodeType;
                    if (r) {
                        if (1 === r || 9 === r || 11 === r) {
                            if ("string" == typeof e.textContent) return e.textContent;
                            for (e = e.firstChild; e; e = e.nextSibling) n += a(e)
                        } else if (3 === r || 4 === r) return e.nodeValue
                    } else
                        for (; t = e[i++];) n += a(t);
                    return n
                }, i = oe.selectors = {
                    cacheLength: 50,
                    createPseudo: ce,
                    match: $,
                    attrHandle: {},
                    find: {},
                    relative: {
                        ">": {
                            dir: "parentNode",
                            first: !0
                        },
                        " ": {
                            dir: "parentNode"
                        },
                        "+": {
                            dir: "previousSibling",
                            first: !0
                        },
                        "~": {
                            dir: "previousSibling"
                        }
                    },
                    preFilter: {
                        ATTR: function(e) {
                            return e[1] = e[1].replace(te, ne), e[3] = (e[3] || e[4] || e[5] || "").replace(te, ne), "~=" === e[2] && (e[3] = " " + e[3] + " "), e.slice(0, 4)
                        },
                        CHILD: function(e) {
                            return e[1] = e[1].toLowerCase(), "nth" === e[1].slice(0, 3) ? (e[3] || oe.error(e[0]), e[4] = +(e[4] ? e[5] + (e[6] || 1) : 2 * ("even" === e[3] || "odd" === e[3])), e[5] = +(e[7] + e[8] || "odd" === e[3])) : e[3] && oe.error(e[0]), e
                        },
                        PSEUDO: function(e) {
                            var t, n = !e[6] && e[2];
                            return $.CHILD.test(e[0]) ? null : (e[3] ? e[2] = e[4] || e[5] || "" : n && X.test(n) && (t = s(n, !0)) && (t = n.indexOf(")", n.length - t) - n.length) && (e[0] = e[0].slice(0, t), e[2] = n.slice(0, t)), e.slice(0, 3))
                        }
                    },
                    filter: {
                        TAG: function(e) {
                            var t = e.replace(te, ne).toLowerCase();
                            return "*" === e ? function() {
                                return !0
                            } : function(e) {
                                return e.nodeName && e.nodeName.toLowerCase() === t
                            }
                        },
                        CLASS: function(e) {
                            var t = M[e + " "];
                            return t || (t = new RegExp("(^|[\\x20\\t\\r\\n\\f])" + e + "(" + N + "|$)")) && M(e, (function(e) {
                                return t.test("string" == typeof e.className && e.className || void 0 !== e.getAttribute && e.getAttribute("class") || "")
                            }))
                        },
                        ATTR: function(e, t, n) {
                            return function(i) {
                                var a = oe.attr(i, e);
                                return null == a ? "!=" === t : !t || (a += "", "=" === t ? a === n : "!=" === t ? a !== n : "^=" === t ? n && 0 === a.indexOf(n) : "*=" === t ? n && a.indexOf(n) > -1 : "$=" === t ? n && a.slice(-n.length) === n : "~=" === t ? (" " + a.replace(z, " ") + " ").indexOf(n) > -1 : "|=" === t && (a === n || a.slice(0, n.length + 1) === n + "-"))
                            }
                        },
                        CHILD: function(e, t, n, i, a) {
                            var r = "nth" !== e.slice(0, 3),
                                s = "last" !== e.slice(-4),
                                o = "of-type" === t;
                            return 1 === i && 0 === a ? function(e) {
                                return !!e.parentNode
                            } : function(t, n, l) {
                                var c, u, d, h, f, p, g = r !== s ? "nextSibling" : "previousSibling",
                                    m = t.parentNode,
                                    v = o && t.nodeName.toLowerCase(),
                                    y = !l && !o,
                                    b = !1;
                                if (m) {
                                    if (r) {
                                        for (; g;) {
                                            for (h = t; h = h[g];)
                                                if (o ? h.nodeName.toLowerCase() === v : 1 === h.nodeType) return !1;
                                            p = g = "only" === e && !p && "nextSibling"
                                        }
                                        return !0
                                    }
                                    if (p = [s ? m.firstChild : m.lastChild], s && y) {
                                        for (b = (f = (c = (u = (d = (h = m)[x] || (h[x] = {}))[h.uniqueID] || (d[h.uniqueID] = {}))[e] || [])[0] === w && c[1]) && c[2], h = f && m.childNodes[f]; h = ++f && h && h[g] || (b = f = 0) || p.pop();)
                                            if (1 === h.nodeType && ++b && h === t) {
                                                u[e] = [w, f, b];
                                                break
                                            }
                                    } else if (y && (b = f = (c = (u = (d = (h = t)[x] || (h[x] = {}))[h.uniqueID] || (d[h.uniqueID] = {}))[e] || [])[0] === w && c[1]), !1 === b)
                                        for (;
                                            (h = ++f && h && h[g] || (b = f = 0) || p.pop()) && ((o ? h.nodeName.toLowerCase() !== v : 1 !== h.nodeType) || !++b || (y && ((u = (d = h[x] || (h[x] = {}))[h.uniqueID] || (d[h.uniqueID] = {}))[e] = [w, b]), h !== t)););
                                    return (b -= a) === i || b % i == 0 && b / i >= 0
                                }
                            }
                        },
                        PSEUDO: function(e, t) {
                            var n, a = i.pseudos[e] || i.setFilters[e.toLowerCase()] || oe.error("unsupported pseudo: " + e);
                            return a[x] ? a(t) : a.length > 1 ? (n = [e, e, "", t], i.setFilters.hasOwnProperty(e.toLowerCase()) ? ce((function(e, n) {
                                for (var i, r = a(e, t), s = r.length; s--;) e[i = I(e, r[s])] = !(n[i] = r[s])
                            })) : function(e) {
                                return a(e, 0, n)
                            }) : a
                        }
                    },
                    pseudos: {
                        not: ce((function(e) {
                            var t = [],
                                n = [],
                                i = o(e.replace(B, "$1"));
                            return i[x] ? ce((function(e, t, n, a) {
                                for (var r, s = i(e, null, a, []), o = e.length; o--;)(r = s[o]) && (e[o] = !(t[o] = r))
                            })) : function(e, a, r) {
                                return t[0] = e, i(t, null, r, n), t[0] = null, !n.pop()
                            }
                        })),
                        has: ce((function(e) {
                            return function(t) {
                                return oe(e, t).length > 0
                            }
                        })),
                        contains: ce((function(e) {
                            return e = e.replace(te, ne),
                                function(t) {
                                    return (t.textContent || a(t)).indexOf(e) > -1
                                }
                        })),
                        lang: ce((function(e) {
                            return U.test(e || "") || oe.error("unsupported lang: " + e), e = e.replace(te, ne).toLowerCase(),
                                function(t) {
                                    var n;
                                    do {
                                        if (n = g ? t.lang : t.getAttribute("xml:lang") || t.getAttribute("lang")) return (n = n.toLowerCase()) === e || 0 === n.indexOf(e + "-")
                                    } while ((t = t.parentNode) && 1 === t.nodeType);
                                    return !1
                                }
                        })),
                        target: function(t) {
                            var n = e.location && e.location.hash;
                            return n && n.slice(1) === t.id
                        },
                        root: function(e) {
                            return e === p
                        },
                        focus: function(e) {
                            return e === f.activeElement && (!f.hasFocus || f.hasFocus()) && !!(e.type || e.href || ~e.tabIndex)
                        },
                        enabled: ge(!1),
                        disabled: ge(!0),
                        checked: function(e) {
                            var t = e.nodeName.toLowerCase();
                            return "input" === t && !!e.checked || "option" === t && !!e.selected
                        },
                        selected: function(e) {
                            return e.parentNode && e.parentNode.selectedIndex, !0 === e.selected
                        },
                        empty: function(e) {
                            for (e = e.firstChild; e; e = e.nextSibling)
                                if (e.nodeType < 6) return !1;
                            return !0
                        },
                        parent: function(e) {
                            return !i.pseudos.empty(e)
                        },
                        header: function(e) {
                            return K.test(e.nodeName)
                        },
                        input: function(e) {
                            return Z.test(e.nodeName)
                        },
                        button: function(e) {
                            var t = e.nodeName.toLowerCase();
                            return "input" === t && "button" === e.type || "button" === t
                        },
                        text: function(e) {
                            var t;
                            return "input" === e.nodeName.toLowerCase() && "text" === e.type && (null == (t = e.getAttribute("type")) || "text" === t.toLowerCase())
                        },
                        first: me((function() {
                            return [0]
                        })),
                        last: me((function(e, t) {
                            return [t - 1]
                        })),
                        eq: me((function(e, t, n) {
                            return [n < 0 ? n + t : n]
                        })),
                        even: me((function(e, t) {
                            for (var n = 0; n < t; n += 2) e.push(n);
                            return e
                        })),
                        odd: me((function(e, t) {
                            for (var n = 1; n < t; n += 2) e.push(n);
                            return e
                        })),
                        lt: me((function(e, t, n) {
                            for (var i = n < 0 ? n + t : n > t ? t : n; --i >= 0;) e.push(i);
                            return e
                        })),
                        gt: me((function(e, t, n) {
                            for (var i = n < 0 ? n + t : n; ++i < t;) e.push(i);
                            return e
                        }))
                    }
                }, i.pseudos.nth = i.pseudos.eq, {
                    radio: !0,
                    checkbox: !0,
                    file: !0,
                    password: !0,
                    image: !0
                }) i.pseudos[t] = fe(t);
            for (t in {
                    submit: !0,
                    reset: !0
                }) i.pseudos[t] = pe(t);

            function ye() {}

            function be(e) {
                for (var t = 0, n = e.length, i = ""; t < n; t++) i += e[t].value;
                return i
            }

            function xe(e, t, n) {
                var i = t.dir,
                    a = t.next,
                    r = a || i,
                    s = n && "parentNode" === r,
                    o = k++;
                return t.first ? function(t, n, a) {
                    for (; t = t[i];)
                        if (1 === t.nodeType || s) return e(t, n, a);
                    return !1
                } : function(t, n, l) {
                    var c, u, d, h = [w, o];
                    if (l) {
                        for (; t = t[i];)
                            if ((1 === t.nodeType || s) && e(t, n, l)) return !0
                    } else
                        for (; t = t[i];)
                            if (1 === t.nodeType || s)
                                if (u = (d = t[x] || (t[x] = {}))[t.uniqueID] || (d[t.uniqueID] = {}), a && a === t.nodeName.toLowerCase()) t = t[i] || t;
                                else {
                                    if ((c = u[r]) && c[0] === w && c[1] === o) return h[2] = c[2];
                                    if (u[r] = h, h[2] = e(t, n, l)) return !0
                                } return !1
                }
            }

            function _e(e) {
                return e.length > 1 ? function(t, n, i) {
                    for (var a = e.length; a--;)
                        if (!e[a](t, n, i)) return !1;
                    return !0
                } : e[0]
            }

            function we(e, t, n, i, a) {
                for (var r, s = [], o = 0, l = e.length, c = null != t; o < l; o++)(r = e[o]) && (n && !n(r, i, a) || (s.push(r), c && t.push(o)));
                return s
            }

            function ke(e, t, n, i, a, r) {
                return i && !i[x] && (i = ke(i)), a && !a[x] && (a = ke(a, r)), ce((function(r, s, o, l) {
                    var c, u, d, h = [],
                        f = [],
                        p = s.length,
                        g = r || function(e, t, n) {
                            for (var i = 0, a = t.length; i < a; i++) oe(e, t[i], n);
                            return n
                        }(t || "*", o.nodeType ? [o] : o, []),
                        m = !e || !r && t ? g : we(g, h, e, o, l),
                        v = n ? a || (r ? e : p || i) ? [] : s : m;
                    if (n && n(m, v, o, l), i)
                        for (c = we(v, f), i(c, [], o, l), u = c.length; u--;)(d = c[u]) && (v[f[u]] = !(m[f[u]] = d));
                    if (r) {
                        if (a || e) {
                            if (a) {
                                for (c = [], u = v.length; u--;)(d = v[u]) && c.push(m[u] = d);
                                a(null, v = [], c, l)
                            }
                            for (u = v.length; u--;)(d = v[u]) && (c = a ? I(r, d) : h[u]) > -1 && (r[c] = !(s[c] = d))
                        }
                    } else v = we(v === s ? v.splice(p, v.length) : v), a ? a(null, s, v, l) : P.apply(s, v)
                }))
            }

            function Me(e) {
                for (var t, n, a, r = e.length, s = i.relative[e[0].type], o = s || i.relative[" "], l = s ? 1 : 0, u = xe((function(e) {
                        return e === t
                    }), o, !0), d = xe((function(e) {
                        return I(t, e) > -1
                    }), o, !0), h = [function(e, n, i) {
                        var a = !s && (i || n !== c) || ((t = n).nodeType ? u(e, n, i) : d(e, n, i));
                        return t = null, a
                    }]; l < r; l++)
                    if (n = i.relative[e[l].type]) h = [xe(_e(h), n)];
                    else {
                        if ((n = i.filter[e[l].type].apply(null, e[l].matches))[x]) {
                            for (a = ++l; a < r && !i.relative[e[a].type]; a++);
                            return ke(l > 1 && _e(h), l > 1 && be(e.slice(0, l - 1).concat({
                                value: " " === e[l - 2].type ? "*" : ""
                            })).replace(B, "$1"), n, l < a && Me(e.slice(l, a)), a < r && Me(e = e.slice(a)), a < r && be(e))
                        }
                        h.push(n)
                    } return _e(h)
            }
            return ye.prototype = i.filters = i.pseudos, i.setFilters = new ye, s = oe.tokenize = function(e, t) {
                var n, a, r, s, o, l, c, u = L[e + " "];
                if (u) return t ? 0 : u.slice(0);
                for (o = e, l = [], c = i.preFilter; o;) {
                    for (s in n && !(a = W.exec(o)) || (a && (o = o.slice(a[0].length) || o), l.push(r = [])), n = !1, (a = V.exec(o)) && (n = a.shift(), r.push({
                            value: n,
                            type: a[0].replace(B, " ")
                        }), o = o.slice(n.length)), i.filter) !(a = $[s].exec(o)) || c[s] && !(a = c[s](a)) || (n = a.shift(), r.push({
                        value: n,
                        type: s,
                        matches: a
                    }), o = o.slice(n.length));
                    if (!n) break
                }
                return t ? o.length : o ? oe.error(e) : L(e, l).slice(0)
            }, o = oe.compile = function(e, t) {
                var n, a = [],
                    r = [],
                    o = S[e + " "];
                if (!o) {
                    for (t || (t = s(e)), n = t.length; n--;)(o = Me(t[n]))[x] ? a.push(o) : r.push(o);
                    o = S(e, function(e, t) {
                        var n = t.length > 0,
                            a = e.length > 0,
                            r = function(r, s, o, l, u) {
                                var d, p, m, v = 0,
                                    y = "0",
                                    b = r && [],
                                    x = [],
                                    _ = c,
                                    k = r || a && i.find.TAG("*", u),
                                    M = w += null == _ ? 1 : Math.random() || .1,
                                    L = k.length;
                                for (u && (c = s == f || s || u); y !== L && null != (d = k[y]); y++) {
                                    if (a && d) {
                                        for (p = 0, s || d.ownerDocument == f || (h(d), o = !g); m = e[p++];)
                                            if (m(d, s || f, o)) {
                                                l.push(d);
                                                break
                                            } u && (w = M)
                                    }
                                    n && ((d = !m && d) && v--, r && b.push(d))
                                }
                                if (v += y, n && y !== v) {
                                    for (p = 0; m = t[p++];) m(b, x, s, o);
                                    if (r) {
                                        if (v > 0)
                                            for (; y--;) b[y] || x[y] || (x[y] = E.call(l));
                                        x = we(x)
                                    }
                                    P.apply(l, x), u && !r && x.length > 0 && v + t.length > 1 && oe.uniqueSort(l)
                                }
                                return u && (w = M, c = _), b
                            };
                        return n ? ce(r) : r
                    }(r, a)), o.selector = e
                }
                return o
            }, l = oe.select = function(e, t, n, a) {
                var r, l, c, u, d, h = "function" == typeof e && e,
                    f = !a && s(e = h.selector || e);
                if (n = n || [], 1 === f.length) {
                    if ((l = f[0] = f[0].slice(0)).length > 2 && "ID" === (c = l[0]).type && 9 === t.nodeType && g && i.relative[l[1].type]) {
                        if (!(t = (i.find.ID(c.matches[0].replace(te, ne), t) || [])[0])) return n;
                        h && (t = t.parentNode), e = e.slice(l.shift().value.length)
                    }
                    for (r = $.needsContext.test(e) ? 0 : l.length; r-- && (c = l[r], !i.relative[u = c.type]);)
                        if ((d = i.find[u]) && (a = d(c.matches[0].replace(te, ne), ee.test(l[0].type) && ve(t.parentNode) || t))) {
                            if (l.splice(r, 1), !(e = a.length && be(l))) return P.apply(n, a), n;
                            break
                        }
                }
                return (h || o(e, f))(a, t, !g, n, !t || ee.test(e) && ve(t.parentNode) || t), n
            }, n.sortStable = x.split("").sort(T).join("") === x, n.detectDuplicates = !!d, h(), n.sortDetached = ue((function(e) {
                return 1 & e.compareDocumentPosition(f.createElement("fieldset"))
            })), ue((function(e) {
                return e.innerHTML = "<a href='#'></a>", "#" === e.firstChild.getAttribute("href")
            })) || de("type|href|height|width", (function(e, t, n) {
                if (!n) return e.getAttribute(t, "type" === t.toLowerCase() ? 1 : 2)
            })), n.attributes && ue((function(e) {
                return e.innerHTML = "<input/>", e.firstChild.setAttribute("value", ""), "" === e.firstChild.getAttribute("value")
            })) || de("value", (function(e, t, n) {
                if (!n && "input" === e.nodeName.toLowerCase()) return e.defaultValue
            })), ue((function(e) {
                return null == e.getAttribute("disabled")
            })) || de(j, (function(e, t, n) {
                var i;
                if (!n) return !0 === e[t] ? t.toLowerCase() : (i = e.getAttributeNode(t)) && i.specified ? i.value : null
            })), oe
        }(e);
    _.find = k, _.expr = k.selectors, _.expr[":"] = _.expr.pseudos, _.uniqueSort = _.unique = k.uniqueSort, _.text = k.getText, _.isXMLDoc = k.isXML, _.contains = k.contains, _.escapeSelector = k.escape;
    var M = function(e, t, n) {
            for (var i = [], a = void 0 !== n;
                (e = e[t]) && 9 !== e.nodeType;)
                if (1 === e.nodeType) {
                    if (a && _(e).is(n)) break;
                    i.push(e)
                } return i
        },
        L = function(e, t) {
            for (var n = []; e; e = e.nextSibling) 1 === e.nodeType && e !== t && n.push(e);
            return n
        },
        S = _.expr.match.needsContext;

    function A(e, t) {
        return e.nodeName && e.nodeName.toLowerCase() === t.toLowerCase()
    }
    var T = /^<([a-z][^\/\0>:\x20\t\r\n\f]*)[\x20\t\r\n\f]*\/?>(?:<\/\1>|)$/i;

    function C(e, t, n) {
        return p(t) ? _.grep(e, (function(e, i) {
            return !!t.call(e, i, e) !== n
        })) : t.nodeType ? _.grep(e, (function(e) {
            return e === t !== n
        })) : "string" != typeof t ? _.grep(e, (function(e) {
            return o.call(t, e) > -1 !== n
        })) : _.filter(t, e, n)
    }
    _.filter = function(e, t, n) {
        var i = t[0];
        return n && (e = ":not(" + e + ")"), 1 === t.length && 1 === i.nodeType ? _.find.matchesSelector(i, e) ? [i] : [] : _.find.matches(e, _.grep(t, (function(e) {
            return 1 === e.nodeType
        })))
    }, _.fn.extend({
        find: function(e) {
            var t, n, i = this.length,
                a = this;
            if ("string" != typeof e) return this.pushStack(_(e).filter((function() {
                for (t = 0; t < i; t++)
                    if (_.contains(a[t], this)) return !0
            })));
            for (n = this.pushStack([]), t = 0; t < i; t++) _.find(e, a[t], n);
            return i > 1 ? _.uniqueSort(n) : n
        },
        filter: function(e) {
            return this.pushStack(C(this, e || [], !1))
        },
        not: function(e) {
            return this.pushStack(C(this, e || [], !0))
        },
        is: function(e) {
            return !!C(this, "string" == typeof e && S.test(e) ? _(e) : e || [], !1).length
        }
    });
    var D, E = /^(?:\s*(<[\w\W]+>)[^>]*|#([\w-]+))$/;
    (_.fn.init = function(e, t, n) {
        var i, a;
        if (!e) return this;
        if (n = n || D, "string" == typeof e) {
            if (!(i = "<" === e[0] && ">" === e[e.length - 1] && e.length >= 3 ? [null, e, null] : E.exec(e)) || !i[1] && t) return !t || t.jquery ? (t || n).find(e) : this.constructor(t).find(e);
            if (i[1]) {
                if (t = t instanceof _ ? t[0] : t, _.merge(this, _.parseHTML(i[1], t && t.nodeType ? t.ownerDocument || t : m, !0)), T.test(i[1]) && _.isPlainObject(t))
                    for (i in t) p(this[i]) ? this[i](t[i]) : this.attr(i, t[i]);
                return this
            }
            return (a = m.getElementById(i[2])) && (this[0] = a, this.length = 1), this
        }
        return e.nodeType ? (this[0] = e, this.length = 1, this) : p(e) ? void 0 !== n.ready ? n.ready(e) : e(_) : _.makeArray(e, this)
    }).prototype = _.fn, D = _(m);
    var O = /^(?:parents|prev(?:Until|All))/,
        P = {
            children: !0,
            contents: !0,
            next: !0,
            prev: !0
        };

    function Y(e, t) {
        for (;
            (e = e[t]) && 1 !== e.nodeType;);
        return e
    }
    _.fn.extend({
        has: function(e) {
            var t = _(e, this),
                n = t.length;
            return this.filter((function() {
                for (var e = 0; e < n; e++)
                    if (_.contains(this, t[e])) return !0
            }))
        },
        closest: function(e, t) {
            var n, i = 0,
                a = this.length,
                r = [],
                s = "string" != typeof e && _(e);
            if (!S.test(e))
                for (; i < a; i++)
                    for (n = this[i]; n && n !== t; n = n.parentNode)
                        if (n.nodeType < 11 && (s ? s.index(n) > -1 : 1 === n.nodeType && _.find.matchesSelector(n, e))) {
                            r.push(n);
                            break
                        } return this.pushStack(r.length > 1 ? _.uniqueSort(r) : r)
        },
        index: function(e) {
            return e ? "string" == typeof e ? o.call(_(e), this[0]) : o.call(this, e.jquery ? e[0] : e) : this[0] && this[0].parentNode ? this.first().prevAll().length : -1
        },
        add: function(e, t) {
            return this.pushStack(_.uniqueSort(_.merge(this.get(), _(e, t))))
        },
        addBack: function(e) {
            return this.add(null == e ? this.prevObject : this.prevObject.filter(e))
        }
    }), _.each({
        parent: function(e) {
            var t = e.parentNode;
            return t && 11 !== t.nodeType ? t : null
        },
        parents: function(e) {
            return M(e, "parentNode")
        },
        parentsUntil: function(e, t, n) {
            return M(e, "parentNode", n)
        },
        next: function(e) {
            return Y(e, "nextSibling")
        },
        prev: function(e) {
            return Y(e, "previousSibling")
        },
        nextAll: function(e) {
            return M(e, "nextSibling")
        },
        prevAll: function(e) {
            return M(e, "previousSibling")
        },
        nextUntil: function(e, t, n) {
            return M(e, "nextSibling", n)
        },
        prevUntil: function(e, t, n) {
            return M(e, "previousSibling", n)
        },
        siblings: function(e) {
            return L((e.parentNode || {}).firstChild, e)
        },
        children: function(e) {
            return L(e.firstChild)
        },
        contents: function(e) {
            return null != e.contentDocument && i(e.contentDocument) ? e.contentDocument : (A(e, "template") && (e = e.content || e), _.merge([], e.childNodes))
        }
    }, (function(e, t) {
        _.fn[e] = function(n, i) {
            var a = _.map(this, t, n);
            return "Until" !== e.slice(-5) && (i = n), i && "string" == typeof i && (a = _.filter(i, a)), this.length > 1 && (P[e] || _.uniqueSort(a), O.test(e) && a.reverse()), this.pushStack(a)
        }
    }));
    var I = /[^\x20\t\r\n\f]+/g;

    function j(e) {
        return e
    }

    function N(e) {
        throw e
    }

    function H(e, t, n, i) {
        var a;
        try {
            e && p(a = e.promise) ? a.call(e).done(t).fail(n) : e && p(a = e.then) ? a.call(e, t, n) : t.apply(void 0, [e].slice(i))
        } catch (e) {
            n.apply(void 0, [e])
        }
    }
    _.Callbacks = function(e) {
        e = "string" == typeof e ? function(e) {
            var t = {};
            return _.each(e.match(I) || [], (function(e, n) {
                t[n] = !0
            })), t
        }(e) : _.extend({}, e);
        var t, n, i, a, r = [],
            s = [],
            o = -1,
            l = function() {
                for (a = a || e.once, i = t = !0; s.length; o = -1)
                    for (n = s.shift(); ++o < r.length;) !1 === r[o].apply(n[0], n[1]) && e.stopOnFalse && (o = r.length, n = !1);
                e.memory || (n = !1), t = !1, a && (r = n ? [] : "")
            },
            c = {
                add: function() {
                    return r && (n && !t && (o = r.length - 1, s.push(n)), function t(n) {
                        _.each(n, (function(n, i) {
                            p(i) ? e.unique && c.has(i) || r.push(i) : i && i.length && "string" !== b(i) && t(i)
                        }))
                    }(arguments), n && !t && l()), this
                },
                remove: function() {
                    return _.each(arguments, (function(e, t) {
                        for (var n;
                            (n = _.inArray(t, r, n)) > -1;) r.splice(n, 1), n <= o && o--
                    })), this
                },
                has: function(e) {
                    return e ? _.inArray(e, r) > -1 : r.length > 0
                },
                empty: function() {
                    return r && (r = []), this
                },
                disable: function() {
                    return a = s = [], r = n = "", this
                },
                disabled: function() {
                    return !r
                },
                lock: function() {
                    return a = s = [], n || t || (r = n = ""), this
                },
                locked: function() {
                    return !!a
                },
                fireWith: function(e, n) {
                    return a || (n = [e, (n = n || []).slice ? n.slice() : n], s.push(n), t || l()), this
                },
                fire: function() {
                    return c.fireWith(this, arguments), this
                },
                fired: function() {
                    return !!i
                }
            };
        return c
    }, _.extend({
        Deferred: function(t) {
            var n = [
                    ["notify", "progress", _.Callbacks("memory"), _.Callbacks("memory"), 2],
                    ["resolve", "done", _.Callbacks("once memory"), _.Callbacks("once memory"), 0, "resolved"],
                    ["reject", "fail", _.Callbacks("once memory"), _.Callbacks("once memory"), 1, "rejected"]
                ],
                i = "pending",
                a = {
                    state: function() {
                        return i
                    },
                    always: function() {
                        return r.done(arguments).fail(arguments), this
                    },
                    catch: function(e) {
                        return a.then(null, e)
                    },
                    pipe: function() {
                        var e = arguments;
                        return _.Deferred((function(t) {
                            _.each(n, (function(n, i) {
                                var a = p(e[i[4]]) && e[i[4]];
                                r[i[1]]((function() {
                                    var e = a && a.apply(this, arguments);
                                    e && p(e.promise) ? e.promise().progress(t.notify).done(t.resolve).fail(t.reject) : t[i[0] + "With"](this, a ? [e] : arguments)
                                }))
                            })), e = null
                        })).promise()
                    },
                    then: function(t, i, a) {
                        var r = 0;

                        function s(t, n, i, a) {
                            return function() {
                                var o = this,
                                    l = arguments,
                                    c = function() {
                                        var e, c;
                                        if (!(t < r)) {
                                            if ((e = i.apply(o, l)) === n.promise()) throw new TypeError("Thenable self-resolution");
                                            c = e && ("object" == typeof e || "function" == typeof e) && e.then, p(c) ? a ? c.call(e, s(r, n, j, a), s(r, n, N, a)) : (r++, c.call(e, s(r, n, j, a), s(r, n, N, a), s(r, n, j, n.notifyWith))) : (i !== j && (o = void 0, l = [e]), (a || n.resolveWith)(o, l))
                                        }
                                    },
                                    u = a ? c : function() {
                                        try {
                                            c()
                                        } catch (e) {
                                            _.Deferred.exceptionHook && _.Deferred.exceptionHook(e, u.stackTrace), t + 1 >= r && (i !== N && (o = void 0, l = [e]), n.rejectWith(o, l))
                                        }
                                    };
                                t ? u() : (_.Deferred.getStackHook && (u.stackTrace = _.Deferred.getStackHook()), e.setTimeout(u))
                            }
                        }
                        return _.Deferred((function(e) {
                            n[0][3].add(s(0, e, p(a) ? a : j, e.notifyWith)), n[1][3].add(s(0, e, p(t) ? t : j)), n[2][3].add(s(0, e, p(i) ? i : N))
                        })).promise()
                    },
                    promise: function(e) {
                        return null != e ? _.extend(e, a) : a
                    }
                },
                r = {};
            return _.each(n, (function(e, t) {
                var s = t[2],
                    o = t[5];
                a[t[1]] = s.add, o && s.add((function() {
                    i = o
                }), n[3 - e][2].disable, n[3 - e][3].disable, n[0][2].lock, n[0][3].lock), s.add(t[3].fire), r[t[0]] = function() {
                    return r[t[0] + "With"](this === r ? void 0 : this, arguments), this
                }, r[t[0] + "With"] = s.fireWith
            })), a.promise(r), t && t.call(r, r), r
        },
        when: function(e) {
            var t = arguments.length,
                n = t,
                i = Array(n),
                r = a.call(arguments),
                s = _.Deferred(),
                o = function(e) {
                    return function(n) {
                        i[e] = this, r[e] = arguments.length > 1 ? a.call(arguments) : n, --t || s.resolveWith(i, r)
                    }
                };
            if (t <= 1 && (H(e, s.done(o(n)).resolve, s.reject, !t), "pending" === s.state() || p(r[n] && r[n].then))) return s.then();
            for (; n--;) H(r[n], o(n), s.reject);
            return s.promise()
        }
    });
    var F = /^(Eval|Internal|Range|Reference|Syntax|Type|URI)Error$/;
    _.Deferred.exceptionHook = function(t, n) {
        e.console && e.console.warn && t && F.test(t.name) && e.console.warn("jQuery.Deferred exception: " + t.message, t.stack, n)
    }, _.readyException = function(t) {
        e.setTimeout((function() {
            throw t
        }))
    };
    var R = _.Deferred();

    function z() {
        m.removeEventListener("DOMContentLoaded", z), e.removeEventListener("load", z), _.ready()
    }
    _.fn.ready = function(e) {
        return R.then(e).catch((function(e) {
            _.readyException(e)
        })), this
    }, _.extend({
        isReady: !1,
        readyWait: 1,
        ready: function(e) {
            (!0 === e ? --_.readyWait : _.isReady) || (_.isReady = !0, !0 !== e && --_.readyWait > 0 || R.resolveWith(m, [_]))
        }
    }), _.ready.then = R.then, "complete" === m.readyState || "loading" !== m.readyState && !m.documentElement.doScroll ? e.setTimeout(_.ready) : (m.addEventListener("DOMContentLoaded", z), e.addEventListener("load", z));
    var B = function(e, t, n, i, a, r, s) {
            var o = 0,
                l = e.length,
                c = null == n;
            if ("object" === b(n))
                for (o in a = !0, n) B(e, t, o, n[o], !0, r, s);
            else if (void 0 !== i && (a = !0, p(i) || (s = !0), c && (s ? (t.call(e, i), t = null) : (c = t, t = function(e, t, n) {
                    return c.call(_(e), n)
                })), t))
                for (; o < l; o++) t(e[o], n, s ? i : i.call(e[o], o, t(e[o], n)));
            return a ? e : c ? t.call(e) : l ? t(e[0], n) : r
        },
        W = /^-ms-/,
        V = /-([a-z])/g;

    function q(e, t) {
        return t.toUpperCase()
    }

    function X(e) {
        return e.replace(W, "ms-").replace(V, q)
    }
    var U = function(e) {
        return 1 === e.nodeType || 9 === e.nodeType || !+e.nodeType
    };

    function $() {
        this.expando = _.expando + $.uid++
    }
    $.uid = 1, $.prototype = {
        cache: function(e) {
            var t = e[this.expando];
            return t || (t = {}, U(e) && (e.nodeType ? e[this.expando] = t : Object.defineProperty(e, this.expando, {
                value: t,
                configurable: !0
            }))), t
        },
        set: function(e, t, n) {
            var i, a = this.cache(e);
            if ("string" == typeof t) a[X(t)] = n;
            else
                for (i in t) a[X(i)] = t[i];
            return a
        },
        get: function(e, t) {
            return void 0 === t ? this.cache(e) : e[this.expando] && e[this.expando][X(t)]
        },
        access: function(e, t, n) {
            return void 0 === t || t && "string" == typeof t && void 0 === n ? this.get(e, t) : (this.set(e, t, n), void 0 !== n ? n : t)
        },
        remove: function(e, t) {
            var n, i = e[this.expando];
            if (void 0 !== i) {
                if (void 0 !== t) {
                    n = (t = Array.isArray(t) ? t.map(X) : (t = X(t)) in i ? [t] : t.match(I) || []).length;
                    for (; n--;) delete i[t[n]]
                }(void 0 === t || _.isEmptyObject(i)) && (e.nodeType ? e[this.expando] = void 0 : delete e[this.expando])
            }
        },
        hasData: function(e) {
            var t = e[this.expando];
            return void 0 !== t && !_.isEmptyObject(t)
        }
    };
    var G = new $,
        Z = new $,
        K = /^(?:\{[\w\W]*\}|\[[\w\W]*\])$/,
        J = /[A-Z]/g;

    function Q(e, t, n) {
        var i;
        if (void 0 === n && 1 === e.nodeType)
            if (i = "data-" + t.replace(J, "-$&").toLowerCase(), "string" == typeof(n = e.getAttribute(i))) {
                try {
                    n = function(e) {
                        return "true" === e || "false" !== e && ("null" === e ? null : e === +e + "" ? +e : K.test(e) ? JSON.parse(e) : e)
                    }(n)
                } catch (e) {}
                Z.set(e, t, n)
            } else n = void 0;
        return n
    }
    _.extend({
        hasData: function(e) {
            return Z.hasData(e) || G.hasData(e)
        },
        data: function(e, t, n) {
            return Z.access(e, t, n)
        },
        removeData: function(e, t) {
            Z.remove(e, t)
        },
        _data: function(e, t, n) {
            return G.access(e, t, n)
        },
        _removeData: function(e, t) {
            G.remove(e, t)
        }
    }), _.fn.extend({
        data: function(e, t) {
            var n, i, a, r = this[0],
                s = r && r.attributes;
            if (void 0 === e) {
                if (this.length && (a = Z.get(r), 1 === r.nodeType && !G.get(r, "hasDataAttrs"))) {
                    for (n = s.length; n--;) s[n] && 0 === (i = s[n].name).indexOf("data-") && (i = X(i.slice(5)), Q(r, i, a[i]));
                    G.set(r, "hasDataAttrs", !0)
                }
                return a
            }
            return "object" == typeof e ? this.each((function() {
                Z.set(this, e)
            })) : B(this, (function(t) {
                var n;
                if (r && void 0 === t) return void 0 !== (n = Z.get(r, e)) || void 0 !== (n = Q(r, e)) ? n : void 0;
                this.each((function() {
                    Z.set(this, e, t)
                }))
            }), null, t, arguments.length > 1, null, !0)
        },
        removeData: function(e) {
            return this.each((function() {
                Z.remove(this, e)
            }))
        }
    }), _.extend({
        queue: function(e, t, n) {
            var i;
            if (e) return t = (t || "fx") + "queue", i = G.get(e, t), n && (!i || Array.isArray(n) ? i = G.access(e, t, _.makeArray(n)) : i.push(n)), i || []
        },
        dequeue: function(e, t) {
            t = t || "fx";
            var n = _.queue(e, t),
                i = n.length,
                a = n.shift(),
                r = _._queueHooks(e, t);
            "inprogress" === a && (a = n.shift(), i--), a && ("fx" === t && n.unshift("inprogress"), delete r.stop, a.call(e, (function() {
                _.dequeue(e, t)
            }), r)), !i && r && r.empty.fire()
        },
        _queueHooks: function(e, t) {
            var n = t + "queueHooks";
            return G.get(e, n) || G.access(e, n, {
                empty: _.Callbacks("once memory").add((function() {
                    G.remove(e, [t + "queue", n])
                }))
            })
        }
    }), _.fn.extend({
        queue: function(e, t) {
            var n = 2;
            return "string" != typeof e && (t = e, e = "fx", n--), arguments.length < n ? _.queue(this[0], e) : void 0 === t ? this : this.each((function() {
                var n = _.queue(this, e, t);
                _._queueHooks(this, e), "fx" === e && "inprogress" !== n[0] && _.dequeue(this, e)
            }))
        },
        dequeue: function(e) {
            return this.each((function() {
                _.dequeue(this, e)
            }))
        },
        clearQueue: function(e) {
            return this.queue(e || "fx", [])
        },
        promise: function(e, t) {
            var n, i = 1,
                a = _.Deferred(),
                r = this,
                s = this.length,
                o = function() {
                    --i || a.resolveWith(r, [r])
                };
            for ("string" != typeof e && (t = e, e = void 0), e = e || "fx"; s--;)(n = G.get(r[s], e + "queueHooks")) && n.empty && (i++, n.empty.add(o));
            return o(), a.promise(t)
        }
    });
    var ee = /[+-]?(?:\d*\.|)\d+(?:[eE][+-]?\d+|)/.source,
        te = new RegExp("^(?:([+-])=|)(" + ee + ")([a-z%]*)$", "i"),
        ne = ["Top", "Right", "Bottom", "Left"],
        ie = m.documentElement,
        ae = function(e) {
            return _.contains(e.ownerDocument, e)
        },
        re = {
            composed: !0
        };
    ie.getRootNode && (ae = function(e) {
        return _.contains(e.ownerDocument, e) || e.getRootNode(re) === e.ownerDocument
    });
    var se = function(e, t) {
        return "none" === (e = t || e).style.display || "" === e.style.display && ae(e) && "none" === _.css(e, "display")
    };

    function oe(e, t, n, i) {
        var a, r, s = 20,
            o = i ? function() {
                return i.cur()
            } : function() {
                return _.css(e, t, "")
            },
            l = o(),
            c = n && n[3] || (_.cssNumber[t] ? "" : "px"),
            u = e.nodeType && (_.cssNumber[t] || "px" !== c && +l) && te.exec(_.css(e, t));
        if (u && u[3] !== c) {
            for (l /= 2, c = c || u[3], u = +l || 1; s--;) _.style(e, t, u + c), (1 - r) * (1 - (r = o() / l || .5)) <= 0 && (s = 0), u /= r;
            u *= 2, _.style(e, t, u + c), n = n || []
        }
        return n && (u = +u || +l || 0, a = n[1] ? u + (n[1] + 1) * n[2] : +n[2], i && (i.unit = c, i.start = u, i.end = a)), a
    }
    var le = {};

    function ce(e) {
        var t, n = e.ownerDocument,
            i = e.nodeName,
            a = le[i];
        return a || (t = n.body.appendChild(n.createElement(i)), a = _.css(t, "display"), t.parentNode.removeChild(t), "none" === a && (a = "block"), le[i] = a, a)
    }

    function ue(e, t) {
        for (var n, i, a = [], r = 0, s = e.length; r < s; r++)(i = e[r]).style && (n = i.style.display, t ? ("none" === n && (a[r] = G.get(i, "display") || null, a[r] || (i.style.display = "")), "" === i.style.display && se(i) && (a[r] = ce(i))) : "none" !== n && (a[r] = "none", G.set(i, "display", n)));
        for (r = 0; r < s; r++) null != a[r] && (e[r].style.display = a[r]);
        return e
    }
    _.fn.extend({
        show: function() {
            return ue(this, !0)
        },
        hide: function() {
            return ue(this)
        },
        toggle: function(e) {
            return "boolean" == typeof e ? e ? this.show() : this.hide() : this.each((function() {
                se(this) ? _(this).show() : _(this).hide()
            }))
        }
    });
    var de, he, fe = /^(?:checkbox|radio)$/i,
        pe = /<([a-z][^\/\0>\x20\t\r\n\f]*)/i,
        ge = /^$|^module$|\/(?:java|ecma)script/i;
    de = m.createDocumentFragment().appendChild(m.createElement("div")), (he = m.createElement("input")).setAttribute("type", "radio"), he.setAttribute("checked", "checked"), he.setAttribute("name", "t"), de.appendChild(he), f.checkClone = de.cloneNode(!0).cloneNode(!0).lastChild.checked, de.innerHTML = "<textarea>x</textarea>", f.noCloneChecked = !!de.cloneNode(!0).lastChild.defaultValue, de.innerHTML = "<option></option>", f.option = !!de.lastChild;
    var me = {
        thead: [1, "<table>", "</table>"],
        col: [2, "<table><colgroup>", "</colgroup></table>"],
        tr: [2, "<table><tbody>", "</tbody></table>"],
        td: [3, "<table><tbody><tr>", "</tr></tbody></table>"],
        _default: [0, "", ""]
    };

    function ve(e, t) {
        var n;
        return n = void 0 !== e.getElementsByTagName ? e.getElementsByTagName(t || "*") : void 0 !== e.querySelectorAll ? e.querySelectorAll(t || "*") : [], void 0 === t || t && A(e, t) ? _.merge([e], n) : n
    }

    function ye(e, t) {
        for (var n = 0, i = e.length; n < i; n++) G.set(e[n], "globalEval", !t || G.get(t[n], "globalEval"))
    }
    me.tbody = me.tfoot = me.colgroup = me.caption = me.thead, me.th = me.td, f.option || (me.optgroup = me.option = [1, "<select multiple='multiple'>", "</select>"]);
    var be = /<|&#?\w+;/;

    function xe(e, t, n, i, a) {
        for (var r, s, o, l, c, u, d = t.createDocumentFragment(), h = [], f = 0, p = e.length; f < p; f++)
            if ((r = e[f]) || 0 === r)
                if ("object" === b(r)) _.merge(h, r.nodeType ? [r] : r);
                else if (be.test(r)) {
            for (s = s || d.appendChild(t.createElement("div")), o = (pe.exec(r) || ["", ""])[1].toLowerCase(), l = me[o] || me._default, s.innerHTML = l[1] + _.htmlPrefilter(r) + l[2], u = l[0]; u--;) s = s.lastChild;
            _.merge(h, s.childNodes), (s = d.firstChild).textContent = ""
        } else h.push(t.createTextNode(r));
        for (d.textContent = "", f = 0; r = h[f++];)
            if (i && _.inArray(r, i) > -1) a && a.push(r);
            else if (c = ae(r), s = ve(d.appendChild(r), "script"), c && ye(s), n)
            for (u = 0; r = s[u++];) ge.test(r.type || "") && n.push(r);
        return d
    }
    var _e = /^([^.]*)(?:\.(.+)|)/;

    function we() {
        return !0
    }

    function ke() {
        return !1
    }

    function Me(e, t) {
        return e === function() {
            try {
                return m.activeElement
            } catch (e) {}
        }() == ("focus" === t)
    }

    function Le(e, t, n, i, a, r) {
        var s, o;
        if ("object" == typeof t) {
            for (o in "string" != typeof n && (i = i || n, n = void 0), t) Le(e, o, n, i, t[o], r);
            return e
        }
        if (null == i && null == a ? (a = n, i = n = void 0) : null == a && ("string" == typeof n ? (a = i, i = void 0) : (a = i, i = n, n = void 0)), !1 === a) a = ke;
        else if (!a) return e;
        return 1 === r && (s = a, a = function(e) {
            return _().off(e), s.apply(this, arguments)
        }, a.guid = s.guid || (s.guid = _.guid++)), e.each((function() {
            _.event.add(this, t, a, i, n)
        }))
    }

    function Se(e, t, n) {
        n ? (G.set(e, t, !1), _.event.add(e, t, {
            namespace: !1,
            handler: function(e) {
                var i, r, s = G.get(this, t);
                if (1 & e.isTrigger && this[t]) {
                    if (s.length)(_.event.special[t] || {}).delegateType && e.stopPropagation();
                    else if (s = a.call(arguments), G.set(this, t, s), i = n(this, t), this[t](), s !== (r = G.get(this, t)) || i ? G.set(this, t, !1) : r = {}, s !== r) return e.stopImmediatePropagation(), e.preventDefault(), r && r.value
                } else s.length && (G.set(this, t, {
                    value: _.event.trigger(_.extend(s[0], _.Event.prototype), s.slice(1), this)
                }), e.stopImmediatePropagation())
            }
        })) : void 0 === G.get(e, t) && _.event.add(e, t, we)
    }
    _.event = {
        global: {},
        add: function(e, t, n, i, a) {
            var r, s, o, l, c, u, d, h, f, p, g, m = G.get(e);
            if (U(e))
                for (n.handler && (n = (r = n).handler, a = r.selector), a && _.find.matchesSelector(ie, a), n.guid || (n.guid = _.guid++), (l = m.events) || (l = m.events = Object.create(null)), (s = m.handle) || (s = m.handle = function(t) {
                        return void 0 !== _ && _.event.triggered !== t.type ? _.event.dispatch.apply(e, arguments) : void 0
                    }), c = (t = (t || "").match(I) || [""]).length; c--;) f = g = (o = _e.exec(t[c]) || [])[1], p = (o[2] || "").split(".").sort(), f && (d = _.event.special[f] || {}, f = (a ? d.delegateType : d.bindType) || f, d = _.event.special[f] || {}, u = _.extend({
                    type: f,
                    origType: g,
                    data: i,
                    handler: n,
                    guid: n.guid,
                    selector: a,
                    needsContext: a && _.expr.match.needsContext.test(a),
                    namespace: p.join(".")
                }, r), (h = l[f]) || ((h = l[f] = []).delegateCount = 0, d.setup && !1 !== d.setup.call(e, i, p, s) || e.addEventListener && e.addEventListener(f, s)), d.add && (d.add.call(e, u), u.handler.guid || (u.handler.guid = n.guid)), a ? h.splice(h.delegateCount++, 0, u) : h.push(u), _.event.global[f] = !0)
        },
        remove: function(e, t, n, i, a) {
            var r, s, o, l, c, u, d, h, f, p, g, m = G.hasData(e) && G.get(e);
            if (m && (l = m.events)) {
                for (c = (t = (t || "").match(I) || [""]).length; c--;)
                    if (f = g = (o = _e.exec(t[c]) || [])[1], p = (o[2] || "").split(".").sort(), f) {
                        for (d = _.event.special[f] || {}, h = l[f = (i ? d.delegateType : d.bindType) || f] || [], o = o[2] && new RegExp("(^|\\.)" + p.join("\\.(?:.*\\.|)") + "(\\.|$)"), s = r = h.length; r--;) u = h[r], !a && g !== u.origType || n && n.guid !== u.guid || o && !o.test(u.namespace) || i && i !== u.selector && ("**" !== i || !u.selector) || (h.splice(r, 1), u.selector && h.delegateCount--, d.remove && d.remove.call(e, u));
                        s && !h.length && (d.teardown && !1 !== d.teardown.call(e, p, m.handle) || _.removeEvent(e, f, m.handle), delete l[f])
                    } else
                        for (f in l) _.event.remove(e, f + t[c], n, i, !0);
                _.isEmptyObject(l) && G.remove(e, "handle events")
            }
        },
        dispatch: function(e) {
            var t, n, i, a, r, s, o = new Array(arguments.length),
                l = _.event.fix(e),
                c = (G.get(this, "events") || Object.create(null))[l.type] || [],
                u = _.event.special[l.type] || {};
            for (o[0] = l, t = 1; t < arguments.length; t++) o[t] = arguments[t];
            if (l.delegateTarget = this, !u.preDispatch || !1 !== u.preDispatch.call(this, l)) {
                for (s = _.event.handlers.call(this, l, c), t = 0;
                    (a = s[t++]) && !l.isPropagationStopped();)
                    for (l.currentTarget = a.elem, n = 0;
                        (r = a.handlers[n++]) && !l.isImmediatePropagationStopped();) l.rnamespace && !1 !== r.namespace && !l.rnamespace.test(r.namespace) || (l.handleObj = r, l.data = r.data, void 0 !== (i = ((_.event.special[r.origType] || {}).handle || r.handler).apply(a.elem, o)) && !1 === (l.result = i) && (l.preventDefault(), l.stopPropagation()));
                return u.postDispatch && u.postDispatch.call(this, l), l.result
            }
        },
        handlers: function(e, t) {
            var n, i, a, r, s, o = [],
                l = t.delegateCount,
                c = e.target;
            if (l && c.nodeType && !("click" === e.type && e.button >= 1))
                for (; c !== this; c = c.parentNode || this)
                    if (1 === c.nodeType && ("click" !== e.type || !0 !== c.disabled)) {
                        for (r = [], s = {}, n = 0; n < l; n++) void 0 === s[a = (i = t[n]).selector + " "] && (s[a] = i.needsContext ? _(a, this).index(c) > -1 : _.find(a, this, null, [c]).length), s[a] && r.push(i);
                        r.length && o.push({
                            elem: c,
                            handlers: r
                        })
                    } return c = this, l < t.length && o.push({
                elem: c,
                handlers: t.slice(l)
            }), o
        },
        addProp: function(e, t) {
            Object.defineProperty(_.Event.prototype, e, {
                enumerable: !0,
                configurable: !0,
                get: p(t) ? function() {
                    if (this.originalEvent) return t(this.originalEvent)
                } : function() {
                    if (this.originalEvent) return this.originalEvent[e]
                },
                set: function(t) {
                    Object.defineProperty(this, e, {
                        enumerable: !0,
                        configurable: !0,
                        writable: !0,
                        value: t
                    })
                }
            })
        },
        fix: function(e) {
            return e[_.expando] ? e : new _.Event(e)
        },
        special: {
            load: {
                noBubble: !0
            },
            click: {
                setup: function(e) {
                    var t = this || e;
                    return fe.test(t.type) && t.click && A(t, "input") && Se(t, "click", we), !1
                },
                trigger: function(e) {
                    var t = this || e;
                    return fe.test(t.type) && t.click && A(t, "input") && Se(t, "click"), !0
                },
                _default: function(e) {
                    var t = e.target;
                    return fe.test(t.type) && t.click && A(t, "input") && G.get(t, "click") || A(t, "a")
                }
            },
            beforeunload: {
                postDispatch: function(e) {
                    void 0 !== e.result && e.originalEvent && (e.originalEvent.returnValue = e.result)
                }
            }
        }
    }, _.removeEvent = function(e, t, n) {
        e.removeEventListener && e.removeEventListener(t, n)
    }, _.Event = function(e, t) {
        if (!(this instanceof _.Event)) return new _.Event(e, t);
        e && e.type ? (this.originalEvent = e, this.type = e.type, this.isDefaultPrevented = e.defaultPrevented || void 0 === e.defaultPrevented && !1 === e.returnValue ? we : ke, this.target = e.target && 3 === e.target.nodeType ? e.target.parentNode : e.target, this.currentTarget = e.currentTarget, this.relatedTarget = e.relatedTarget) : this.type = e, t && _.extend(this, t), this.timeStamp = e && e.timeStamp || Date.now(), this[_.expando] = !0
    }, _.Event.prototype = {
        constructor: _.Event,
        isDefaultPrevented: ke,
        isPropagationStopped: ke,
        isImmediatePropagationStopped: ke,
        isSimulated: !1,
        preventDefault: function() {
            var e = this.originalEvent;
            this.isDefaultPrevented = we, e && !this.isSimulated && e.preventDefault()
        },
        stopPropagation: function() {
            var e = this.originalEvent;
            this.isPropagationStopped = we, e && !this.isSimulated && e.stopPropagation()
        },
        stopImmediatePropagation: function() {
            var e = this.originalEvent;
            this.isImmediatePropagationStopped = we, e && !this.isSimulated && e.stopImmediatePropagation(), this.stopPropagation()
        }
    }, _.each({
        altKey: !0,
        bubbles: !0,
        cancelable: !0,
        changedTouches: !0,
        ctrlKey: !0,
        detail: !0,
        eventPhase: !0,
        metaKey: !0,
        pageX: !0,
        pageY: !0,
        shiftKey: !0,
        view: !0,
        char: !0,
        code: !0,
        charCode: !0,
        key: !0,
        keyCode: !0,
        button: !0,
        buttons: !0,
        clientX: !0,
        clientY: !0,
        offsetX: !0,
        offsetY: !0,
        pointerId: !0,
        pointerType: !0,
        screenX: !0,
        screenY: !0,
        targetTouches: !0,
        toElement: !0,
        touches: !0,
        which: !0
    }, _.event.addProp), _.each({
        focus: "focusin",
        blur: "focusout"
    }, (function(e, t) {
        _.event.special[e] = {
            setup: function() {
                return Se(this, e, Me), !1
            },
            trigger: function() {
                return Se(this, e), !0
            },
            _default: function() {
                return !0
            },
            delegateType: t
        }
    })), _.each({
        mouseenter: "mouseover",
        mouseleave: "mouseout",
        pointerenter: "pointerover",
        pointerleave: "pointerout"
    }, (function(e, t) {
        _.event.special[e] = {
            delegateType: t,
            bindType: t,
            handle: function(e) {
                var n, i = this,
                    a = e.relatedTarget,
                    r = e.handleObj;
                return a && (a === i || _.contains(i, a)) || (e.type = r.origType, n = r.handler.apply(this, arguments), e.type = t), n
            }
        }
    })), _.fn.extend({
        on: function(e, t, n, i) {
            return Le(this, e, t, n, i)
        },
        one: function(e, t, n, i) {
            return Le(this, e, t, n, i, 1)
        },
        off: function(e, t, n) {
            var i, a;
            if (e && e.preventDefault && e.handleObj) return i = e.handleObj, _(e.delegateTarget).off(i.namespace ? i.origType + "." + i.namespace : i.origType, i.selector, i.handler), this;
            if ("object" == typeof e) {
                for (a in e) this.off(a, t, e[a]);
                return this
            }
            return !1 !== t && "function" != typeof t || (n = t, t = void 0), !1 === n && (n = ke), this.each((function() {
                _.event.remove(this, e, n, t)
            }))
        }
    });
    var Ae = /<script|<style|<link/i,
        Te = /checked\s*(?:[^=]|=\s*.checked.)/i,
        Ce = /^\s*<!(?:\[CDATA\[|--)|(?:\]\]|--)>\s*$/g;

    function De(e, t) {
        return A(e, "table") && A(11 !== t.nodeType ? t : t.firstChild, "tr") && _(e).children("tbody")[0] || e
    }

    function Ee(e) {
        return e.type = (null !== e.getAttribute("type")) + "/" + e.type, e
    }

    function Oe(e) {
        return "true/" === (e.type || "").slice(0, 5) ? e.type = e.type.slice(5) : e.removeAttribute("type"), e
    }

    function Pe(e, t) {
        var n, i, a, r, s, o;
        if (1 === t.nodeType) {
            if (G.hasData(e) && (o = G.get(e).events))
                for (a in G.remove(t, "handle events"), o)
                    for (n = 0, i = o[a].length; n < i; n++) _.event.add(t, a, o[a][n]);
            Z.hasData(e) && (r = Z.access(e), s = _.extend({}, r), Z.set(t, s))
        }
    }

    function Ye(e, t) {
        var n = t.nodeName.toLowerCase();
        "input" === n && fe.test(e.type) ? t.checked = e.checked : "input" !== n && "textarea" !== n || (t.defaultValue = e.defaultValue)
    }

    function Ie(e, t, n, i) {
        t = r(t);
        var a, s, o, l, c, u, d = 0,
            h = e.length,
            g = h - 1,
            m = t[0],
            v = p(m);
        if (v || h > 1 && "string" == typeof m && !f.checkClone && Te.test(m)) return e.each((function(a) {
            var r = e.eq(a);
            v && (t[0] = m.call(this, a, r.html())), Ie(r, t, n, i)
        }));
        if (h && (s = (a = xe(t, e[0].ownerDocument, !1, e, i)).firstChild, 1 === a.childNodes.length && (a = s), s || i)) {
            for (l = (o = _.map(ve(a, "script"), Ee)).length; d < h; d++) c = a, d !== g && (c = _.clone(c, !0, !0), l && _.merge(o, ve(c, "script"))), n.call(e[d], c, d);
            if (l)
                for (u = o[o.length - 1].ownerDocument, _.map(o, Oe), d = 0; d < l; d++) c = o[d], ge.test(c.type || "") && !G.access(c, "globalEval") && _.contains(u, c) && (c.src && "module" !== (c.type || "").toLowerCase() ? _._evalUrl && !c.noModule && _._evalUrl(c.src, {
                    nonce: c.nonce || c.getAttribute("nonce")
                }, u) : y(c.textContent.replace(Ce, ""), c, u))
        }
        return e
    }

    function je(e, t, n) {
        for (var i, a = t ? _.filter(t, e) : e, r = 0; null != (i = a[r]); r++) n || 1 !== i.nodeType || _.cleanData(ve(i)), i.parentNode && (n && ae(i) && ye(ve(i, "script")), i.parentNode.removeChild(i));
        return e
    }
    _.extend({
        htmlPrefilter: function(e) {
            return e
        },
        clone: function(e, t, n) {
            var i, a, r, s, o = e.cloneNode(!0),
                l = ae(e);
            if (!(f.noCloneChecked || 1 !== e.nodeType && 11 !== e.nodeType || _.isXMLDoc(e)))
                for (s = ve(o), i = 0, a = (r = ve(e)).length; i < a; i++) Ye(r[i], s[i]);
            if (t)
                if (n)
                    for (r = r || ve(e), s = s || ve(o), i = 0, a = r.length; i < a; i++) Pe(r[i], s[i]);
                else Pe(e, o);
            return (s = ve(o, "script")).length > 0 && ye(s, !l && ve(e, "script")), o
        },
        cleanData: function(e) {
            for (var t, n, i, a = _.event.special, r = 0; void 0 !== (n = e[r]); r++)
                if (U(n)) {
                    if (t = n[G.expando]) {
                        if (t.events)
                            for (i in t.events) a[i] ? _.event.remove(n, i) : _.removeEvent(n, i, t.handle);
                        n[G.expando] = void 0
                    }
                    n[Z.expando] && (n[Z.expando] = void 0)
                }
        }
    }), _.fn.extend({
        detach: function(e) {
            return je(this, e, !0)
        },
        remove: function(e) {
            return je(this, e)
        },
        text: function(e) {
            return B(this, (function(e) {
                return void 0 === e ? _.text(this) : this.empty().each((function() {
                    1 !== this.nodeType && 11 !== this.nodeType && 9 !== this.nodeType || (this.textContent = e)
                }))
            }), null, e, arguments.length)
        },
        append: function() {
            return Ie(this, arguments, (function(e) {
                1 !== this.nodeType && 11 !== this.nodeType && 9 !== this.nodeType || De(this, e).appendChild(e)
            }))
        },
        prepend: function() {
            return Ie(this, arguments, (function(e) {
                if (1 === this.nodeType || 11 === this.nodeType || 9 === this.nodeType) {
                    var t = De(this, e);
                    t.insertBefore(e, t.firstChild)
                }
            }))
        },
        before: function() {
            return Ie(this, arguments, (function(e) {
                this.parentNode && this.parentNode.insertBefore(e, this)
            }))
        },
        after: function() {
            return Ie(this, arguments, (function(e) {
                this.parentNode && this.parentNode.insertBefore(e, this.nextSibling)
            }))
        },
        empty: function() {
            for (var e, t = 0; null != (e = this[t]); t++) 1 === e.nodeType && (_.cleanData(ve(e, !1)), e.textContent = "");
            return this
        },
        clone: function(e, t) {
            return e = null != e && e, t = null == t ? e : t, this.map((function() {
                return _.clone(this, e, t)
            }))
        },
        html: function(e) {
            return B(this, (function(e) {
                var t = this[0] || {},
                    n = 0,
                    i = this.length;
                if (void 0 === e && 1 === t.nodeType) return t.innerHTML;
                if ("string" == typeof e && !Ae.test(e) && !me[(pe.exec(e) || ["", ""])[1].toLowerCase()]) {
                    e = _.htmlPrefilter(e);
                    try {
                        for (; n < i; n++) 1 === (t = this[n] || {}).nodeType && (_.cleanData(ve(t, !1)), t.innerHTML = e);
                        t = 0
                    } catch (e) {}
                }
                t && this.empty().append(e)
            }), null, e, arguments.length)
        },
        replaceWith: function() {
            var e = [];
            return Ie(this, arguments, (function(t) {
                var n = this.parentNode;
                _.inArray(this, e) < 0 && (_.cleanData(ve(this)), n && n.replaceChild(t, this))
            }), e)
        }
    }), _.each({
        appendTo: "append",
        prependTo: "prepend",
        insertBefore: "before",
        insertAfter: "after",
        replaceAll: "replaceWith"
    }, (function(e, t) {
        _.fn[e] = function(e) {
            for (var n, i = [], a = _(e), r = a.length - 1, o = 0; o <= r; o++) n = o === r ? this : this.clone(!0), _(a[o])[t](n), s.apply(i, n.get());
            return this.pushStack(i)
        }
    }));
    var Ne = new RegExp("^(" + ee + ")(?!px)[a-z%]+$", "i"),
        He = function(t) {
            var n = t.ownerDocument.defaultView;
            return n && n.opener || (n = e), n.getComputedStyle(t)
        },
        Fe = function(e, t, n) {
            var i, a, r = {};
            for (a in t) r[a] = e.style[a], e.style[a] = t[a];
            for (a in i = n.call(e), t) e.style[a] = r[a];
            return i
        },
        Re = new RegExp(ne.join("|"), "i");

    function ze(e, t, n) {
        var i, a, r, s, o = e.style;
        return (n = n || He(e)) && ("" !== (s = n.getPropertyValue(t) || n[t]) || ae(e) || (s = _.style(e, t)), !f.pixelBoxStyles() && Ne.test(s) && Re.test(t) && (i = o.width, a = o.minWidth, r = o.maxWidth, o.minWidth = o.maxWidth = o.width = s, s = n.width, o.width = i, o.minWidth = a, o.maxWidth = r)), void 0 !== s ? s + "" : s
    }

    function Be(e, t) {
        return {
            get: function() {
                if (!e()) return (this.get = t).apply(this, arguments);
                delete this.get
            }
        }
    }! function() {
        function t() {
            if (u) {
                c.style.cssText = "position:absolute;left:-11111px;width:60px;margin-top:1px;padding:0;border:0", u.style.cssText = "position:relative;display:block;box-sizing:border-box;overflow:scroll;margin:auto;border:1px;padding:1px;width:60%;top:1%", ie.appendChild(c).appendChild(u);
                var t = e.getComputedStyle(u);
                i = "1%" !== t.top, l = 12 === n(t.marginLeft), u.style.right = "60%", s = 36 === n(t.right), a = 36 === n(t.width), u.style.position = "absolute", r = 12 === n(u.offsetWidth / 3), ie.removeChild(c), u = null
            }
        }

        function n(e) {
            return Math.round(parseFloat(e))
        }
        var i, a, r, s, o, l, c = m.createElement("div"),
            u = m.createElement("div");
        u.style && (u.style.backgroundClip = "content-box", u.cloneNode(!0).style.backgroundClip = "", f.clearCloneStyle = "content-box" === u.style.backgroundClip, _.extend(f, {
            boxSizingReliable: function() {
                return t(), a
            },
            pixelBoxStyles: function() {
                return t(), s
            },
            pixelPosition: function() {
                return t(), i
            },
            reliableMarginLeft: function() {
                return t(), l
            },
            scrollboxSize: function() {
                return t(), r
            },
            reliableTrDimensions: function() {
                var t, n, i, a;
                return null == o && (t = m.createElement("table"), n = m.createElement("tr"), i = m.createElement("div"), t.style.cssText = "position:absolute;left:-11111px;border-collapse:separate", n.style.cssText = "border:1px solid", n.style.height = "1px", i.style.height = "9px", i.style.display = "block", ie.appendChild(t).appendChild(n).appendChild(i), a = e.getComputedStyle(n), o = parseInt(a.height, 10) + parseInt(a.borderTopWidth, 10) + parseInt(a.borderBottomWidth, 10) === n.offsetHeight, ie.removeChild(t)), o
            }
        }))
    }();
    var We = ["Webkit", "Moz", "ms"],
        Ve = m.createElement("div").style,
        qe = {};

    function Xe(e) {
        var t = _.cssProps[e] || qe[e];
        return t || (e in Ve ? e : qe[e] = function(e) {
            for (var t = e[0].toUpperCase() + e.slice(1), n = We.length; n--;)
                if ((e = We[n] + t) in Ve) return e
        }(e) || e)
    }
    var Ue = /^(none|table(?!-c[ea]).+)/,
        $e = /^--/,
        Ge = {
            position: "absolute",
            visibility: "hidden",
            display: "block"
        },
        Ze = {
            letterSpacing: "0",
            fontWeight: "400"
        };

    function Ke(e, t, n) {
        var i = te.exec(t);
        return i ? Math.max(0, i[2] - (n || 0)) + (i[3] || "px") : t
    }

    function Je(e, t, n, i, a, r) {
        var s = "width" === t ? 1 : 0,
            o = 0,
            l = 0;
        if (n === (i ? "border" : "content")) return 0;
        for (; s < 4; s += 2) "margin" === n && (l += _.css(e, n + ne[s], !0, a)), i ? ("content" === n && (l -= _.css(e, "padding" + ne[s], !0, a)), "margin" !== n && (l -= _.css(e, "border" + ne[s] + "Width", !0, a))) : (l += _.css(e, "padding" + ne[s], !0, a), "padding" !== n ? l += _.css(e, "border" + ne[s] + "Width", !0, a) : o += _.css(e, "border" + ne[s] + "Width", !0, a));
        return !i && r >= 0 && (l += Math.max(0, Math.ceil(e["offset" + t[0].toUpperCase() + t.slice(1)] - r - l - o - .5)) || 0), l
    }

    function Qe(e, t, n) {
        var i = He(e),
            a = (!f.boxSizingReliable() || n) && "border-box" === _.css(e, "boxSizing", !1, i),
            r = a,
            s = ze(e, t, i),
            o = "offset" + t[0].toUpperCase() + t.slice(1);
        if (Ne.test(s)) {
            if (!n) return s;
            s = "auto"
        }
        return (!f.boxSizingReliable() && a || !f.reliableTrDimensions() && A(e, "tr") || "auto" === s || !parseFloat(s) && "inline" === _.css(e, "display", !1, i)) && e.getClientRects().length && (a = "border-box" === _.css(e, "boxSizing", !1, i), (r = o in e) && (s = e[o])), (s = parseFloat(s) || 0) + Je(e, t, n || (a ? "border" : "content"), r, i, s) + "px"
    }

    function et(e, t, n, i, a) {
        return new et.prototype.init(e, t, n, i, a)
    }
    _.extend({
        cssHooks: {
            opacity: {
                get: function(e, t) {
                    if (t) {
                        var n = ze(e, "opacity");
                        return "" === n ? "1" : n
                    }
                }
            }
        },
        cssNumber: {
            animationIterationCount: !0,
            columnCount: !0,
            fillOpacity: !0,
            flexGrow: !0,
            flexShrink: !0,
            fontWeight: !0,
            gridArea: !0,
            gridColumn: !0,
            gridColumnEnd: !0,
            gridColumnStart: !0,
            gridRow: !0,
            gridRowEnd: !0,
            gridRowStart: !0,
            lineHeight: !0,
            opacity: !0,
            order: !0,
            orphans: !0,
            widows: !0,
            zIndex: !0,
            zoom: !0
        },
        cssProps: {},
        style: function(e, t, n, i) {
            if (e && 3 !== e.nodeType && 8 !== e.nodeType && e.style) {
                var a, r, s, o = X(t),
                    l = $e.test(t),
                    c = e.style;
                if (l || (t = Xe(o)), s = _.cssHooks[t] || _.cssHooks[o], void 0 === n) return s && "get" in s && void 0 !== (a = s.get(e, !1, i)) ? a : c[t];
                "string" === (r = typeof n) && (a = te.exec(n)) && a[1] && (n = oe(e, t, a), r = "number"), null != n && n == n && ("number" !== r || l || (n += a && a[3] || (_.cssNumber[o] ? "" : "px")), f.clearCloneStyle || "" !== n || 0 !== t.indexOf("background") || (c[t] = "inherit"), s && "set" in s && void 0 === (n = s.set(e, n, i)) || (l ? c.setProperty(t, n) : c[t] = n))
            }
        },
        css: function(e, t, n, i) {
            var a, r, s, o = X(t);
            return $e.test(t) || (t = Xe(o)), (s = _.cssHooks[t] || _.cssHooks[o]) && "get" in s && (a = s.get(e, !0, n)), void 0 === a && (a = ze(e, t, i)), "normal" === a && t in Ze && (a = Ze[t]), "" === n || n ? (r = parseFloat(a), !0 === n || isFinite(r) ? r || 0 : a) : a
        }
    }), _.each(["height", "width"], (function(e, t) {
        _.cssHooks[t] = {
            get: function(e, n, i) {
                if (n) return !Ue.test(_.css(e, "display")) || e.getClientRects().length && e.getBoundingClientRect().width ? Qe(e, t, i) : Fe(e, Ge, (function() {
                    return Qe(e, t, i)
                }))
            },
            set: function(e, n, i) {
                var a, r = He(e),
                    s = !f.scrollboxSize() && "absolute" === r.position,
                    o = (s || i) && "border-box" === _.css(e, "boxSizing", !1, r),
                    l = i ? Je(e, t, i, o, r) : 0;
                return o && s && (l -= Math.ceil(e["offset" + t[0].toUpperCase() + t.slice(1)] - parseFloat(r[t]) - Je(e, t, "border", !1, r) - .5)), l && (a = te.exec(n)) && "px" !== (a[3] || "px") && (e.style[t] = n, n = _.css(e, t)), Ke(0, n, l)
            }
        }
    })), _.cssHooks.marginLeft = Be(f.reliableMarginLeft, (function(e, t) {
        if (t) return (parseFloat(ze(e, "marginLeft")) || e.getBoundingClientRect().left - Fe(e, {
            marginLeft: 0
        }, (function() {
            return e.getBoundingClientRect().left
        }))) + "px"
    })), _.each({
        margin: "",
        padding: "",
        border: "Width"
    }, (function(e, t) {
        _.cssHooks[e + t] = {
            expand: function(n) {
                for (var i = 0, a = {}, r = "string" == typeof n ? n.split(" ") : [n]; i < 4; i++) a[e + ne[i] + t] = r[i] || r[i - 2] || r[0];
                return a
            }
        }, "margin" !== e && (_.cssHooks[e + t].set = Ke)
    })), _.fn.extend({
        css: function(e, t) {
            return B(this, (function(e, t, n) {
                var i, a, r = {},
                    s = 0;
                if (Array.isArray(t)) {
                    for (i = He(e), a = t.length; s < a; s++) r[t[s]] = _.css(e, t[s], !1, i);
                    return r
                }
                return void 0 !== n ? _.style(e, t, n) : _.css(e, t)
            }), e, t, arguments.length > 1)
        }
    }), _.Tween = et, et.prototype = {
        constructor: et,
        init: function(e, t, n, i, a, r) {
            this.elem = e, this.prop = n, this.easing = a || _.easing._default, this.options = t, this.start = this.now = this.cur(), this.end = i, this.unit = r || (_.cssNumber[n] ? "" : "px")
        },
        cur: function() {
            var e = et.propHooks[this.prop];
            return e && e.get ? e.get(this) : et.propHooks._default.get(this)
        },
        run: function(e) {
            var t, n = et.propHooks[this.prop];
            return this.options.duration ? this.pos = t = _.easing[this.easing](e, this.options.duration * e, 0, 1, this.options.duration) : this.pos = t = e, this.now = (this.end - this.start) * t + this.start, this.options.step && this.options.step.call(this.elem, this.now, this), n && n.set ? n.set(this) : et.propHooks._default.set(this), this
        }
    }, et.prototype.init.prototype = et.prototype, et.propHooks = {
        _default: {
            get: function(e) {
                var t;
                return 1 !== e.elem.nodeType || null != e.elem[e.prop] && null == e.elem.style[e.prop] ? e.elem[e.prop] : (t = _.css(e.elem, e.prop, "")) && "auto" !== t ? t : 0
            },
            set: function(e) {
                _.fx.step[e.prop] ? _.fx.step[e.prop](e) : 1 !== e.elem.nodeType || !_.cssHooks[e.prop] && null == e.elem.style[Xe(e.prop)] ? e.elem[e.prop] = e.now : _.style(e.elem, e.prop, e.now + e.unit)
            }
        }
    }, et.propHooks.scrollTop = et.propHooks.scrollLeft = {
        set: function(e) {
            e.elem.nodeType && e.elem.parentNode && (e.elem[e.prop] = e.now)
        }
    }, _.easing = {
        linear: function(e) {
            return e
        },
        swing: function(e) {
            return .5 - Math.cos(e * Math.PI) / 2
        },
        _default: "swing"
    }, _.fx = et.prototype.init, _.fx.step = {};
    var tt, nt, it = /^(?:toggle|show|hide)$/,
        at = /queueHooks$/;

    function rt() {
        nt && (!1 === m.hidden && e.requestAnimationFrame ? e.requestAnimationFrame(rt) : e.setTimeout(rt, _.fx.interval), _.fx.tick())
    }

    function st() {
        return e.setTimeout((function() {
            tt = void 0
        })), tt = Date.now()
    }

    function ot(e, t) {
        var n, i = 0,
            a = {
                height: e
            };
        for (t = t ? 1 : 0; i < 4; i += 2 - t) a["margin" + (n = ne[i])] = a["padding" + n] = e;
        return t && (a.opacity = a.width = e), a
    }

    function lt(e, t, n) {
        for (var i, a = (ct.tweeners[t] || []).concat(ct.tweeners["*"]), r = 0, s = a.length; r < s; r++)
            if (i = a[r].call(n, t, e)) return i
    }

    function ct(e, t, n) {
        var i, a, r = 0,
            s = ct.prefilters.length,
            o = _.Deferred().always((function() {
                delete l.elem
            })),
            l = function() {
                if (a) return !1;
                for (var t = tt || st(), n = Math.max(0, c.startTime + c.duration - t), i = 1 - (n / c.duration || 0), r = 0, s = c.tweens.length; r < s; r++) c.tweens[r].run(i);
                return o.notifyWith(e, [c, i, n]), i < 1 && s ? n : (s || o.notifyWith(e, [c, 1, 0]), o.resolveWith(e, [c]), !1)
            },
            c = o.promise({
                elem: e,
                props: _.extend({}, t),
                opts: _.extend(!0, {
                    specialEasing: {},
                    easing: _.easing._default
                }, n),
                originalProperties: t,
                originalOptions: n,
                startTime: tt || st(),
                duration: n.duration,
                tweens: [],
                createTween: function(t, n) {
                    var i = _.Tween(e, c.opts, t, n, c.opts.specialEasing[t] || c.opts.easing);
                    return c.tweens.push(i), i
                },
                stop: function(t) {
                    var n = 0,
                        i = t ? c.tweens.length : 0;
                    if (a) return this;
                    for (a = !0; n < i; n++) c.tweens[n].run(1);
                    return t ? (o.notifyWith(e, [c, 1, 0]), o.resolveWith(e, [c, t])) : o.rejectWith(e, [c, t]), this
                }
            }),
            u = c.props;
        for (! function(e, t) {
                var n, i, a, r, s;
                for (n in e)
                    if (a = t[i = X(n)], r = e[n], Array.isArray(r) && (a = r[1], r = e[n] = r[0]), n !== i && (e[i] = r, delete e[n]), (s = _.cssHooks[i]) && "expand" in s)
                        for (n in r = s.expand(r), delete e[i], r) n in e || (e[n] = r[n], t[n] = a);
                    else t[i] = a
            }(u, c.opts.specialEasing); r < s; r++)
            if (i = ct.prefilters[r].call(c, e, u, c.opts)) return p(i.stop) && (_._queueHooks(c.elem, c.opts.queue).stop = i.stop.bind(i)), i;
        return _.map(u, lt, c), p(c.opts.start) && c.opts.start.call(e, c), c.progress(c.opts.progress).done(c.opts.done, c.opts.complete).fail(c.opts.fail).always(c.opts.always), _.fx.timer(_.extend(l, {
            elem: e,
            anim: c,
            queue: c.opts.queue
        })), c
    }
    _.Animation = _.extend(ct, {
            tweeners: {
                "*": [function(e, t) {
                    var n = this.createTween(e, t);
                    return oe(n.elem, e, te.exec(t), n), n
                }]
            },
            tweener: function(e, t) {
                p(e) ? (t = e, e = ["*"]) : e = e.match(I);
                for (var n, i = 0, a = e.length; i < a; i++) n = e[i], ct.tweeners[n] = ct.tweeners[n] || [], ct.tweeners[n].unshift(t)
            },
            prefilters: [function(e, t, n) {
                var i, a, r, s, o, l, c, u, d = "width" in t || "height" in t,
                    h = this,
                    f = {},
                    p = e.style,
                    g = e.nodeType && se(e),
                    m = G.get(e, "fxshow");
                for (i in n.queue || (null == (s = _._queueHooks(e, "fx")).unqueued && (s.unqueued = 0, o = s.empty.fire, s.empty.fire = function() {
                        s.unqueued || o()
                    }), s.unqueued++, h.always((function() {
                        h.always((function() {
                            s.unqueued--, _.queue(e, "fx").length || s.empty.fire()
                        }))
                    }))), t)
                    if (a = t[i], it.test(a)) {
                        if (delete t[i], r = r || "toggle" === a, a === (g ? "hide" : "show")) {
                            if ("show" !== a || !m || void 0 === m[i]) continue;
                            g = !0
                        }
                        f[i] = m && m[i] || _.style(e, i)
                    } if ((l = !_.isEmptyObject(t)) || !_.isEmptyObject(f))
                    for (i in d && 1 === e.nodeType && (n.overflow = [p.overflow, p.overflowX, p.overflowY], null == (c = m && m.display) && (c = G.get(e, "display")), "none" === (u = _.css(e, "display")) && (c ? u = c : (ue([e], !0), c = e.style.display || c, u = _.css(e, "display"), ue([e]))), ("inline" === u || "inline-block" === u && null != c) && "none" === _.css(e, "float") && (l || (h.done((function() {
                            p.display = c
                        })), null == c && (u = p.display, c = "none" === u ? "" : u)), p.display = "inline-block")), n.overflow && (p.overflow = "hidden", h.always((function() {
                            p.overflow = n.overflow[0], p.overflowX = n.overflow[1], p.overflowY = n.overflow[2]
                        }))), l = !1, f) l || (m ? "hidden" in m && (g = m.hidden) : m = G.access(e, "fxshow", {
                        display: c
                    }), r && (m.hidden = !g), g && ue([e], !0), h.done((function() {
                        for (i in g || ue([e]), G.remove(e, "fxshow"), f) _.style(e, i, f[i])
                    }))), l = lt(g ? m[i] : 0, i, h), i in m || (m[i] = l.start, g && (l.end = l.start, l.start = 0))
            }],
            prefilter: function(e, t) {
                t ? ct.prefilters.unshift(e) : ct.prefilters.push(e)
            }
        }), _.speed = function(e, t, n) {
            var i = e && "object" == typeof e ? _.extend({}, e) : {
                complete: n || !n && t || p(e) && e,
                duration: e,
                easing: n && t || t && !p(t) && t
            };
            return _.fx.off ? i.duration = 0 : "number" != typeof i.duration && (i.duration in _.fx.speeds ? i.duration = _.fx.speeds[i.duration] : i.duration = _.fx.speeds._default), null != i.queue && !0 !== i.queue || (i.queue = "fx"), i.old = i.complete, i.complete = function() {
                p(i.old) && i.old.call(this), i.queue && _.dequeue(this, i.queue)
            }, i
        }, _.fn.extend({
            fadeTo: function(e, t, n, i) {
                return this.filter(se).css("opacity", 0).show().end().animate({
                    opacity: t
                }, e, n, i)
            },
            animate: function(e, t, n, i) {
                var a = _.isEmptyObject(e),
                    r = _.speed(t, n, i),
                    s = function() {
                        var t = ct(this, _.extend({}, e), r);
                        (a || G.get(this, "finish")) && t.stop(!0)
                    };
                return s.finish = s, a || !1 === r.queue ? this.each(s) : this.queue(r.queue, s)
            },
            stop: function(e, t, n) {
                var i = function(e) {
                    var t = e.stop;
                    delete e.stop, t(n)
                };
                return "string" != typeof e && (n = t, t = e, e = void 0), t && this.queue(e || "fx", []), this.each((function() {
                    var t = !0,
                        a = null != e && e + "queueHooks",
                        r = _.timers,
                        s = G.get(this);
                    if (a) s[a] && s[a].stop && i(s[a]);
                    else
                        for (a in s) s[a] && s[a].stop && at.test(a) && i(s[a]);
                    for (a = r.length; a--;) r[a].elem !== this || null != e && r[a].queue !== e || (r[a].anim.stop(n), t = !1, r.splice(a, 1));
                    !t && n || _.dequeue(this, e)
                }))
            },
            finish: function(e) {
                return !1 !== e && (e = e || "fx"), this.each((function() {
                    var t, n = G.get(this),
                        i = n[e + "queue"],
                        a = n[e + "queueHooks"],
                        r = _.timers,
                        s = i ? i.length : 0;
                    for (n.finish = !0, _.queue(this, e, []), a && a.stop && a.stop.call(this, !0), t = r.length; t--;) r[t].elem === this && r[t].queue === e && (r[t].anim.stop(!0), r.splice(t, 1));
                    for (t = 0; t < s; t++) i[t] && i[t].finish && i[t].finish.call(this);
                    delete n.finish
                }))
            }
        }), _.each(["toggle", "show", "hide"], (function(e, t) {
            var n = _.fn[t];
            _.fn[t] = function(e, i, a) {
                return null == e || "boolean" == typeof e ? n.apply(this, arguments) : this.animate(ot(t, !0), e, i, a)
            }
        })), _.each({
            slideDown: ot("show"),
            slideUp: ot("hide"),
            slideToggle: ot("toggle"),
            fadeIn: {
                opacity: "show"
            },
            fadeOut: {
                opacity: "hide"
            },
            fadeToggle: {
                opacity: "toggle"
            }
        }, (function(e, t) {
            _.fn[e] = function(e, n, i) {
                return this.animate(t, e, n, i)
            }
        })), _.timers = [], _.fx.tick = function() {
            var e, t = 0,
                n = _.timers;
            for (tt = Date.now(); t < n.length; t++)(e = n[t])() || n[t] !== e || n.splice(t--, 1);
            n.length || _.fx.stop(), tt = void 0
        }, _.fx.timer = function(e) {
            _.timers.push(e), _.fx.start()
        }, _.fx.interval = 13, _.fx.start = function() {
            nt || (nt = !0, rt())
        }, _.fx.stop = function() {
            nt = null
        }, _.fx.speeds = {
            slow: 600,
            fast: 200,
            _default: 400
        }, _.fn.delay = function(t, n) {
            return t = _.fx && _.fx.speeds[t] || t, n = n || "fx", this.queue(n, (function(n, i) {
                var a = e.setTimeout(n, t);
                i.stop = function() {
                    e.clearTimeout(a)
                }
            }))
        },
        function() {
            var e = m.createElement("input"),
                t = m.createElement("select").appendChild(m.createElement("option"));
            e.type = "checkbox", f.checkOn = "" !== e.value, f.optSelected = t.selected, (e = m.createElement("input")).value = "t", e.type = "radio", f.radioValue = "t" === e.value
        }();
    var ut, dt = _.expr.attrHandle;
    _.fn.extend({
        attr: function(e, t) {
            return B(this, _.attr, e, t, arguments.length > 1)
        },
        removeAttr: function(e) {
            return this.each((function() {
                _.removeAttr(this, e)
            }))
        }
    }), _.extend({
        attr: function(e, t, n) {
            var i, a, r = e.nodeType;
            if (3 !== r && 8 !== r && 2 !== r) return void 0 === e.getAttribute ? _.prop(e, t, n) : (1 === r && _.isXMLDoc(e) || (a = _.attrHooks[t.toLowerCase()] || (_.expr.match.bool.test(t) ? ut : void 0)), void 0 !== n ? null === n ? void _.removeAttr(e, t) : a && "set" in a && void 0 !== (i = a.set(e, n, t)) ? i : (e.setAttribute(t, n + ""), n) : a && "get" in a && null !== (i = a.get(e, t)) ? i : null == (i = _.find.attr(e, t)) ? void 0 : i)
        },
        attrHooks: {
            type: {
                set: function(e, t) {
                    if (!f.radioValue && "radio" === t && A(e, "input")) {
                        var n = e.value;
                        return e.setAttribute("type", t), n && (e.value = n), t
                    }
                }
            }
        },
        removeAttr: function(e, t) {
            var n, i = 0,
                a = t && t.match(I);
            if (a && 1 === e.nodeType)
                for (; n = a[i++];) e.removeAttribute(n)
        }
    }), ut = {
        set: function(e, t, n) {
            return !1 === t ? _.removeAttr(e, n) : e.setAttribute(n, n), n
        }
    }, _.each(_.expr.match.bool.source.match(/\w+/g), (function(e, t) {
        var n = dt[t] || _.find.attr;
        dt[t] = function(e, t, i) {
            var a, r, s = t.toLowerCase();
            return i || (r = dt[s], dt[s] = a, a = null != n(e, t, i) ? s : null, dt[s] = r), a
        }
    }));
    var ht = /^(?:input|select|textarea|button)$/i,
        ft = /^(?:a|area)$/i;

    function pt(e) {
        return (e.match(I) || []).join(" ")
    }

    function gt(e) {
        return e.getAttribute && e.getAttribute("class") || ""
    }

    function mt(e) {
        return Array.isArray(e) ? e : "string" == typeof e && e.match(I) || []
    }
    _.fn.extend({
        prop: function(e, t) {
            return B(this, _.prop, e, t, arguments.length > 1)
        },
        removeProp: function(e) {
            return this.each((function() {
                delete this[_.propFix[e] || e]
            }))
        }
    }), _.extend({
        prop: function(e, t, n) {
            var i, a, r = e.nodeType;
            if (3 !== r && 8 !== r && 2 !== r) return 1 === r && _.isXMLDoc(e) || (t = _.propFix[t] || t, a = _.propHooks[t]), void 0 !== n ? a && "set" in a && void 0 !== (i = a.set(e, n, t)) ? i : e[t] = n : a && "get" in a && null !== (i = a.get(e, t)) ? i : e[t]
        },
        propHooks: {
            tabIndex: {
                get: function(e) {
                    var t = _.find.attr(e, "tabindex");
                    return t ? parseInt(t, 10) : ht.test(e.nodeName) || ft.test(e.nodeName) && e.href ? 0 : -1
                }
            }
        },
        propFix: {
            for: "htmlFor",
            class: "className"
        }
    }), f.optSelected || (_.propHooks.selected = {
        get: function(e) {
            var t = e.parentNode;
            return t && t.parentNode && t.parentNode.selectedIndex, null
        },
        set: function(e) {
            var t = e.parentNode;
            t && (t.selectedIndex, t.parentNode && t.parentNode.selectedIndex)
        }
    }), _.each(["tabIndex", "readOnly", "maxLength", "cellSpacing", "cellPadding", "rowSpan", "colSpan", "useMap", "frameBorder", "contentEditable"], (function() {
        _.propFix[this.toLowerCase()] = this
    })), _.fn.extend({
        addClass: function(e) {
            var t, n, i, a, r, s, o, l = 0;
            if (p(e)) return this.each((function(t) {
                _(this).addClass(e.call(this, t, gt(this)))
            }));
            if ((t = mt(e)).length)
                for (; n = this[l++];)
                    if (a = gt(n), i = 1 === n.nodeType && " " + pt(a) + " ") {
                        for (s = 0; r = t[s++];) i.indexOf(" " + r + " ") < 0 && (i += r + " ");
                        a !== (o = pt(i)) && n.setAttribute("class", o)
                    } return this
        },
        removeClass: function(e) {
            var t, n, i, a, r, s, o, l = 0;
            if (p(e)) return this.each((function(t) {
                _(this).removeClass(e.call(this, t, gt(this)))
            }));
            if (!arguments.length) return this.attr("class", "");
            if ((t = mt(e)).length)
                for (; n = this[l++];)
                    if (a = gt(n), i = 1 === n.nodeType && " " + pt(a) + " ") {
                        for (s = 0; r = t[s++];)
                            for (; i.indexOf(" " + r + " ") > -1;) i = i.replace(" " + r + " ", " ");
                        a !== (o = pt(i)) && n.setAttribute("class", o)
                    } return this
        },
        toggleClass: function(e, t) {
            var n = typeof e,
                i = "string" === n || Array.isArray(e);
            return "boolean" == typeof t && i ? t ? this.addClass(e) : this.removeClass(e) : p(e) ? this.each((function(n) {
                _(this).toggleClass(e.call(this, n, gt(this), t), t)
            })) : this.each((function() {
                var t, a, r, s;
                if (i)
                    for (a = 0, r = _(this), s = mt(e); t = s[a++];) r.hasClass(t) ? r.removeClass(t) : r.addClass(t);
                else void 0 !== e && "boolean" !== n || ((t = gt(this)) && G.set(this, "__className__", t), this.setAttribute && this.setAttribute("class", t || !1 === e ? "" : G.get(this, "__className__") || ""))
            }))
        },
        hasClass: function(e) {
            var t, n, i = 0;
            for (t = " " + e + " "; n = this[i++];)
                if (1 === n.nodeType && (" " + pt(gt(n)) + " ").indexOf(t) > -1) return !0;
            return !1
        }
    });
    var vt = /\r/g;
    _.fn.extend({
        val: function(e) {
            var t, n, i, a = this[0];
            return arguments.length ? (i = p(e), this.each((function(n) {
                var a;
                1 === this.nodeType && (null == (a = i ? e.call(this, n, _(this).val()) : e) ? a = "" : "number" == typeof a ? a += "" : Array.isArray(a) && (a = _.map(a, (function(e) {
                    return null == e ? "" : e + ""
                }))), (t = _.valHooks[this.type] || _.valHooks[this.nodeName.toLowerCase()]) && "set" in t && void 0 !== t.set(this, a, "value") || (this.value = a))
            }))) : a ? (t = _.valHooks[a.type] || _.valHooks[a.nodeName.toLowerCase()]) && "get" in t && void 0 !== (n = t.get(a, "value")) ? n : "string" == typeof(n = a.value) ? n.replace(vt, "") : null == n ? "" : n : void 0
        }
    }), _.extend({
        valHooks: {
            option: {
                get: function(e) {
                    var t = _.find.attr(e, "value");
                    return null != t ? t : pt(_.text(e))
                }
            },
            select: {
                get: function(e) {
                    var t, n, i, a = e.options,
                        r = e.selectedIndex,
                        s = "select-one" === e.type,
                        o = s ? null : [],
                        l = s ? r + 1 : a.length;
                    for (i = r < 0 ? l : s ? r : 0; i < l; i++)
                        if (((n = a[i]).selected || i === r) && !n.disabled && (!n.parentNode.disabled || !A(n.parentNode, "optgroup"))) {
                            if (t = _(n).val(), s) return t;
                            o.push(t)
                        } return o
                },
                set: function(e, t) {
                    for (var n, i, a = e.options, r = _.makeArray(t), s = a.length; s--;)((i = a[s]).selected = _.inArray(_.valHooks.option.get(i), r) > -1) && (n = !0);
                    return n || (e.selectedIndex = -1), r
                }
            }
        }
    }), _.each(["radio", "checkbox"], (function() {
        _.valHooks[this] = {
            set: function(e, t) {
                if (Array.isArray(t)) return e.checked = _.inArray(_(e).val(), t) > -1
            }
        }, f.checkOn || (_.valHooks[this].get = function(e) {
            return null === e.getAttribute("value") ? "on" : e.value
        })
    })), f.focusin = "onfocusin" in e;
    var yt = /^(?:focusinfocus|focusoutblur)$/,
        bt = function(e) {
            e.stopPropagation()
        };
    _.extend(_.event, {
        trigger: function(t, n, i, a) {
            var r, s, o, l, c, d, h, f, v = [i || m],
                y = u.call(t, "type") ? t.type : t,
                b = u.call(t, "namespace") ? t.namespace.split(".") : [];
            if (s = f = o = i = i || m, 3 !== i.nodeType && 8 !== i.nodeType && !yt.test(y + _.event.triggered) && (y.indexOf(".") > -1 && (b = y.split("."), y = b.shift(), b.sort()), c = y.indexOf(":") < 0 && "on" + y, (t = t[_.expando] ? t : new _.Event(y, "object" == typeof t && t)).isTrigger = a ? 2 : 3, t.namespace = b.join("."), t.rnamespace = t.namespace ? new RegExp("(^|\\.)" + b.join("\\.(?:.*\\.|)") + "(\\.|$)") : null, t.result = void 0, t.target || (t.target = i), n = null == n ? [t] : _.makeArray(n, [t]), h = _.event.special[y] || {}, a || !h.trigger || !1 !== h.trigger.apply(i, n))) {
                if (!a && !h.noBubble && !g(i)) {
                    for (l = h.delegateType || y, yt.test(l + y) || (s = s.parentNode); s; s = s.parentNode) v.push(s), o = s;
                    o === (i.ownerDocument || m) && v.push(o.defaultView || o.parentWindow || e)
                }
                for (r = 0;
                    (s = v[r++]) && !t.isPropagationStopped();) f = s, t.type = r > 1 ? l : h.bindType || y, (d = (G.get(s, "events") || Object.create(null))[t.type] && G.get(s, "handle")) && d.apply(s, n), (d = c && s[c]) && d.apply && U(s) && (t.result = d.apply(s, n), !1 === t.result && t.preventDefault());
                return t.type = y, a || t.isDefaultPrevented() || h._default && !1 !== h._default.apply(v.pop(), n) || !U(i) || c && p(i[y]) && !g(i) && ((o = i[c]) && (i[c] = null), _.event.triggered = y, t.isPropagationStopped() && f.addEventListener(y, bt), i[y](), t.isPropagationStopped() && f.removeEventListener(y, bt), _.event.triggered = void 0, o && (i[c] = o)), t.result
            }
        },
        simulate: function(e, t, n) {
            var i = _.extend(new _.Event, n, {
                type: e,
                isSimulated: !0
            });
            _.event.trigger(i, null, t)
        }
    }), _.fn.extend({
        trigger: function(e, t) {
            return this.each((function() {
                _.event.trigger(e, t, this)
            }))
        },
        triggerHandler: function(e, t) {
            var n = this[0];
            if (n) return _.event.trigger(e, t, n, !0)
        }
    }), f.focusin || _.each({
        focus: "focusin",
        blur: "focusout"
    }, (function(e, t) {
        var n = function(e) {
            _.event.simulate(t, e.target, _.event.fix(e))
        };
        _.event.special[t] = {
            setup: function() {
                var i = this.ownerDocument || this.document || this,
                    a = G.access(i, t);
                a || i.addEventListener(e, n, !0), G.access(i, t, (a || 0) + 1)
            },
            teardown: function() {
                var i = this.ownerDocument || this.document || this,
                    a = G.access(i, t) - 1;
                a ? G.access(i, t, a) : (i.removeEventListener(e, n, !0), G.remove(i, t))
            }
        }
    }));
    var xt = e.location,
        _t = {
            guid: Date.now()
        },
        wt = /\?/;
    _.parseXML = function(t) {
        var n, i;
        if (!t || "string" != typeof t) return null;
        try {
            n = (new e.DOMParser).parseFromString(t, "text/xml")
        } catch (e) {}
        return i = n && n.getElementsByTagName("parsererror")[0], n && !i || _.error("Invalid XML: " + (i ? _.map(i.childNodes, (function(e) {
            return e.textContent
        })).join("\n") : t)), n
    };
    var kt = /\[\]$/,
        Mt = /\r?\n/g,
        Lt = /^(?:submit|button|image|reset|file)$/i,
        St = /^(?:input|select|textarea|keygen)/i;

    function At(e, t, n, i) {
        var a;
        if (Array.isArray(t)) _.each(t, (function(t, a) {
            n || kt.test(e) ? i(e, a) : At(e + "[" + ("object" == typeof a && null != a ? t : "") + "]", a, n, i)
        }));
        else if (n || "object" !== b(t)) i(e, t);
        else
            for (a in t) At(e + "[" + a + "]", t[a], n, i)
    }
    _.param = function(e, t) {
        var n, i = [],
            a = function(e, t) {
                var n = p(t) ? t() : t;
                i[i.length] = encodeURIComponent(e) + "=" + encodeURIComponent(null == n ? "" : n)
            };
        if (null == e) return "";
        if (Array.isArray(e) || e.jquery && !_.isPlainObject(e)) _.each(e, (function() {
            a(this.name, this.value)
        }));
        else
            for (n in e) At(n, e[n], t, a);
        return i.join("&")
    }, _.fn.extend({
        serialize: function() {
            return _.param(this.serializeArray())
        },
        serializeArray: function() {
            return this.map((function() {
                var e = _.prop(this, "elements");
                return e ? _.makeArray(e) : this
            })).filter((function() {
                var e = this.type;
                return this.name && !_(this).is(":disabled") && St.test(this.nodeName) && !Lt.test(e) && (this.checked || !fe.test(e))
            })).map((function(e, t) {
                var n = _(this).val();
                return null == n ? null : Array.isArray(n) ? _.map(n, (function(e) {
                    return {
                        name: t.name,
                        value: e.replace(Mt, "\r\n")
                    }
                })) : {
                    name: t.name,
                    value: n.replace(Mt, "\r\n")
                }
            })).get()
        }
    });
    var Tt = /%20/g,
        Ct = /#.*$/,
        Dt = /([?&])_=[^&]*/,
        Et = /^(.*?):[ \t]*([^\r\n]*)$/gm,
        Ot = /^(?:GET|HEAD)$/,
        Pt = /^\/\//,
        Yt = {},
        It = {},
        jt = "*/".concat("*"),
        Nt = m.createElement("a");

    function Ht(e) {
        return function(t, n) {
            "string" != typeof t && (n = t, t = "*");
            var i, a = 0,
                r = t.toLowerCase().match(I) || [];
            if (p(n))
                for (; i = r[a++];) "+" === i[0] ? (i = i.slice(1) || "*", (e[i] = e[i] || []).unshift(n)) : (e[i] = e[i] || []).push(n)
        }
    }

    function Ft(e, t, n, i) {
        var a = {},
            r = e === It;

        function s(o) {
            var l;
            return a[o] = !0, _.each(e[o] || [], (function(e, o) {
                var c = o(t, n, i);
                return "string" != typeof c || r || a[c] ? r ? !(l = c) : void 0 : (t.dataTypes.unshift(c), s(c), !1)
            })), l
        }
        return s(t.dataTypes[0]) || !a["*"] && s("*")
    }

    function Rt(e, t) {
        var n, i, a = _.ajaxSettings.flatOptions || {};
        for (n in t) void 0 !== t[n] && ((a[n] ? e : i || (i = {}))[n] = t[n]);
        return i && _.extend(!0, e, i), e
    }
    Nt.href = xt.href, _.extend({
        active: 0,
        lastModified: {},
        etag: {},
        ajaxSettings: {
            url: xt.href,
            type: "GET",
            isLocal: /^(?:about|app|app-storage|.+-extension|file|res|widget):$/.test(xt.protocol),
            global: !0,
            processData: !0,
            async: !0,
            contentType: "application/x-www-form-urlencoded; charset=UTF-8",
            accepts: {
                "*": jt,
                text: "text/plain",
                html: "text/html",
                xml: "application/xml, text/xml",
                json: "application/json, text/javascript"
            },
            contents: {
                xml: /\bxml\b/,
                html: /\bhtml/,
                json: /\bjson\b/
            },
            responseFields: {
                xml: "responseXML",
                text: "responseText",
                json: "responseJSON"
            },
            converters: {
                "* text": String,
                "text html": !0,
                "text json": JSON.parse,
                "text xml": _.parseXML
            },
            flatOptions: {
                url: !0,
                context: !0
            }
        },
        ajaxSetup: function(e, t) {
            return t ? Rt(Rt(e, _.ajaxSettings), t) : Rt(_.ajaxSettings, e)
        },
        ajaxPrefilter: Ht(Yt),
        ajaxTransport: Ht(It),
        ajax: function(t, n) {
            "object" == typeof t && (n = t, t = void 0), n = n || {};
            var i, a, r, s, o, l, c, u, d, h, f = _.ajaxSetup({}, n),
                p = f.context || f,
                g = f.context && (p.nodeType || p.jquery) ? _(p) : _.event,
                v = _.Deferred(),
                y = _.Callbacks("once memory"),
                b = f.statusCode || {},
                x = {},
                w = {},
                k = "canceled",
                M = {
                    readyState: 0,
                    getResponseHeader: function(e) {
                        var t;
                        if (c) {
                            if (!s)
                                for (s = {}; t = Et.exec(r);) s[t[1].toLowerCase() + " "] = (s[t[1].toLowerCase() + " "] || []).concat(t[2]);
                            t = s[e.toLowerCase() + " "]
                        }
                        return null == t ? null : t.join(", ")
                    },
                    getAllResponseHeaders: function() {
                        return c ? r : null
                    },
                    setRequestHeader: function(e, t) {
                        return null == c && (e = w[e.toLowerCase()] = w[e.toLowerCase()] || e, x[e] = t), this
                    },
                    overrideMimeType: function(e) {
                        return null == c && (f.mimeType = e), this
                    },
                    statusCode: function(e) {
                        var t;
                        if (e)
                            if (c) M.always(e[M.status]);
                            else
                                for (t in e) b[t] = [b[t], e[t]];
                        return this
                    },
                    abort: function(e) {
                        var t = e || k;
                        return i && i.abort(t), L(0, t), this
                    }
                };
            if (v.promise(M), f.url = ((t || f.url || xt.href) + "").replace(Pt, xt.protocol + "//"), f.type = n.method || n.type || f.method || f.type, f.dataTypes = (f.dataType || "*").toLowerCase().match(I) || [""], null == f.crossDomain) {
                l = m.createElement("a");
                try {
                    l.href = f.url, l.href = l.href, f.crossDomain = Nt.protocol + "//" + Nt.host != l.protocol + "//" + l.host
                } catch (e) {
                    f.crossDomain = !0
                }
            }
            if (f.data && f.processData && "string" != typeof f.data && (f.data = _.param(f.data, f.traditional)), Ft(Yt, f, n, M), c) return M;
            for (d in (u = _.event && f.global) && 0 == _.active++ && _.event.trigger("ajaxStart"), f.type = f.type.toUpperCase(), f.hasContent = !Ot.test(f.type), a = f.url.replace(Ct, ""), f.hasContent ? f.data && f.processData && 0 === (f.contentType || "").indexOf("application/x-www-form-urlencoded") && (f.data = f.data.replace(Tt, "+")) : (h = f.url.slice(a.length), f.data && (f.processData || "string" == typeof f.data) && (a += (wt.test(a) ? "&" : "?") + f.data, delete f.data), !1 === f.cache && (a = a.replace(Dt, "$1"), h = (wt.test(a) ? "&" : "?") + "_=" + _t.guid++ + h), f.url = a + h), f.ifModified && (_.lastModified[a] && M.setRequestHeader("If-Modified-Since", _.lastModified[a]), _.etag[a] && M.setRequestHeader("If-None-Match", _.etag[a])), (f.data && f.hasContent && !1 !== f.contentType || n.contentType) && M.setRequestHeader("Content-Type", f.contentType), M.setRequestHeader("Accept", f.dataTypes[0] && f.accepts[f.dataTypes[0]] ? f.accepts[f.dataTypes[0]] + ("*" !== f.dataTypes[0] ? ", " + jt + "; q=0.01" : "") : f.accepts["*"]), f.headers) M.setRequestHeader(d, f.headers[d]);
            if (f.beforeSend && (!1 === f.beforeSend.call(p, M, f) || c)) return M.abort();
            if (k = "abort", y.add(f.complete), M.done(f.success), M.fail(f.error), i = Ft(It, f, n, M)) {
                if (M.readyState = 1, u && g.trigger("ajaxSend", [M, f]), c) return M;
                f.async && f.timeout > 0 && (o = e.setTimeout((function() {
                    M.abort("timeout")
                }), f.timeout));
                try {
                    c = !1, i.send(x, L)
                } catch (e) {
                    if (c) throw e;
                    L(-1, e)
                }
            } else L(-1, "No Transport");

            function L(t, n, s, l) {
                var d, h, m, x, w, k = n;
                c || (c = !0, o && e.clearTimeout(o), i = void 0, r = l || "", M.readyState = t > 0 ? 4 : 0, d = t >= 200 && t < 300 || 304 === t, s && (x = function(e, t, n) {
                    for (var i, a, r, s, o = e.contents, l = e.dataTypes;
                        "*" === l[0];) l.shift(), void 0 === i && (i = e.mimeType || t.getResponseHeader("Content-Type"));
                    if (i)
                        for (a in o)
                            if (o[a] && o[a].test(i)) {
                                l.unshift(a);
                                break
                            } if (l[0] in n) r = l[0];
                    else {
                        for (a in n) {
                            if (!l[0] || e.converters[a + " " + l[0]]) {
                                r = a;
                                break
                            }
                            s || (s = a)
                        }
                        r = r || s
                    }
                    if (r) return r !== l[0] && l.unshift(r), n[r]
                }(f, M, s)), !d && _.inArray("script", f.dataTypes) > -1 && _.inArray("json", f.dataTypes) < 0 && (f.converters["text script"] = function() {}), x = function(e, t, n, i) {
                    var a, r, s, o, l, c = {},
                        u = e.dataTypes.slice();
                    if (u[1])
                        for (s in e.converters) c[s.toLowerCase()] = e.converters[s];
                    for (r = u.shift(); r;)
                        if (e.responseFields[r] && (n[e.responseFields[r]] = t), !l && i && e.dataFilter && (t = e.dataFilter(t, e.dataType)), l = r, r = u.shift())
                            if ("*" === r) r = l;
                            else if ("*" !== l && l !== r) {
                        if (!(s = c[l + " " + r] || c["* " + r]))
                            for (a in c)
                                if ((o = a.split(" "))[1] === r && (s = c[l + " " + o[0]] || c["* " + o[0]])) {
                                    !0 === s ? s = c[a] : !0 !== c[a] && (r = o[0], u.unshift(o[1]));
                                    break
                                } if (!0 !== s)
                            if (s && e.throws) t = s(t);
                            else try {
                                t = s(t)
                            } catch (e) {
                                return {
                                    state: "parsererror",
                                    error: s ? e : "No conversion from " + l + " to " + r
                                }
                            }
                    }
                    return {
                        state: "success",
                        data: t
                    }
                }(f, x, M, d), d ? (f.ifModified && ((w = M.getResponseHeader("Last-Modified")) && (_.lastModified[a] = w), (w = M.getResponseHeader("etag")) && (_.etag[a] = w)), 204 === t || "HEAD" === f.type ? k = "nocontent" : 304 === t ? k = "notmodified" : (k = x.state, h = x.data, d = !(m = x.error))) : (m = k, !t && k || (k = "error", t < 0 && (t = 0))), M.status = t, M.statusText = (n || k) + "", d ? v.resolveWith(p, [h, k, M]) : v.rejectWith(p, [M, k, m]), M.statusCode(b), b = void 0, u && g.trigger(d ? "ajaxSuccess" : "ajaxError", [M, f, d ? h : m]), y.fireWith(p, [M, k]), u && (g.trigger("ajaxComplete", [M, f]), --_.active || _.event.trigger("ajaxStop")))
            }
            return M
        },
        getJSON: function(e, t, n) {
            return _.get(e, t, n, "json")
        },
        getScript: function(e, t) {
            return _.get(e, void 0, t, "script")
        }
    }), _.each(["get", "post"], (function(e, t) {
        _[t] = function(e, n, i, a) {
            return p(n) && (a = a || i, i = n, n = void 0), _.ajax(_.extend({
                url: e,
                type: t,
                dataType: a,
                data: n,
                success: i
            }, _.isPlainObject(e) && e))
        }
    })), _.ajaxPrefilter((function(e) {
        var t;
        for (t in e.headers) "content-type" === t.toLowerCase() && (e.contentType = e.headers[t] || "")
    })), _._evalUrl = function(e, t, n) {
        return _.ajax({
            url: e,
            type: "GET",
            dataType: "script",
            cache: !0,
            async: !1,
            global: !1,
            converters: {
                "text script": function() {}
            },
            dataFilter: function(e) {
                _.globalEval(e, t, n)
            }
        })
    }, _.fn.extend({
        wrapAll: function(e) {
            var t;
            return this[0] && (p(e) && (e = e.call(this[0])), t = _(e, this[0].ownerDocument).eq(0).clone(!0), this[0].parentNode && t.insertBefore(this[0]), t.map((function() {
                for (var e = this; e.firstElementChild;) e = e.firstElementChild;
                return e
            })).append(this)), this
        },
        wrapInner: function(e) {
            return p(e) ? this.each((function(t) {
                _(this).wrapInner(e.call(this, t))
            })) : this.each((function() {
                var t = _(this),
                    n = t.contents();
                n.length ? n.wrapAll(e) : t.append(e)
            }))
        },
        wrap: function(e) {
            var t = p(e);
            return this.each((function(n) {
                _(this).wrapAll(t ? e.call(this, n) : e)
            }))
        },
        unwrap: function(e) {
            return this.parent(e).not("body").each((function() {
                _(this).replaceWith(this.childNodes)
            })), this
        }
    }), _.expr.pseudos.hidden = function(e) {
        return !_.expr.pseudos.visible(e)
    }, _.expr.pseudos.visible = function(e) {
        return !!(e.offsetWidth || e.offsetHeight || e.getClientRects().length)
    }, _.ajaxSettings.xhr = function() {
        try {
            return new e.XMLHttpRequest
        } catch (e) {}
    };
    var zt = {
            0: 200,
            1223: 204
        },
        Bt = _.ajaxSettings.xhr();
    f.cors = !!Bt && "withCredentials" in Bt, f.ajax = Bt = !!Bt, _.ajaxTransport((function(t) {
        var n, i;
        if (f.cors || Bt && !t.crossDomain) return {
            send: function(a, r) {
                var s, o = t.xhr();
                if (o.open(t.type, t.url, t.async, t.username, t.password), t.xhrFields)
                    for (s in t.xhrFields) o[s] = t.xhrFields[s];
                for (s in t.mimeType && o.overrideMimeType && o.overrideMimeType(t.mimeType), t.crossDomain || a["X-Requested-With"] || (a["X-Requested-With"] = "XMLHttpRequest"), a) o.setRequestHeader(s, a[s]);
                n = function(e) {
                    return function() {
                        n && (n = i = o.onload = o.onerror = o.onabort = o.ontimeout = o.onreadystatechange = null, "abort" === e ? o.abort() : "error" === e ? "number" != typeof o.status ? r(0, "error") : r(o.status, o.statusText) : r(zt[o.status] || o.status, o.statusText, "text" !== (o.responseType || "text") || "string" != typeof o.responseText ? {
                            binary: o.response
                        } : {
                            text: o.responseText
                        }, o.getAllResponseHeaders()))
                    }
                }, o.onload = n(), i = o.onerror = o.ontimeout = n("error"), void 0 !== o.onabort ? o.onabort = i : o.onreadystatechange = function() {
                    4 === o.readyState && e.setTimeout((function() {
                        n && i()
                    }))
                }, n = n("abort");
                try {
                    o.send(t.hasContent && t.data || null)
                } catch (e) {
                    if (n) throw e
                }
            },
            abort: function() {
                n && n()
            }
        }
    })), _.ajaxPrefilter((function(e) {
        e.crossDomain && (e.contents.script = !1)
    })), _.ajaxSetup({
        accepts: {
            script: "text/javascript, application/javascript, application/ecmascript, application/x-ecmascript"
        },
        contents: {
            script: /\b(?:java|ecma)script\b/
        },
        converters: {
            "text script": function(e) {
                return _.globalEval(e), e
            }
        }
    }), _.ajaxPrefilter("script", (function(e) {
        void 0 === e.cache && (e.cache = !1), e.crossDomain && (e.type = "GET")
    })), _.ajaxTransport("script", (function(e) {
        var t, n;
        if (e.crossDomain || e.scriptAttrs) return {
            send: function(i, a) {
                t = _("<script>").attr(e.scriptAttrs || {}).prop({
                    charset: e.scriptCharset,
                    src: e.url
                }).on("load error", n = function(e) {
                    t.remove(), n = null, e && a("error" === e.type ? 404 : 200, e.type)
                }), m.head.appendChild(t[0])
            },
            abort: function() {
                n && n()
            }
        }
    }));
    var Wt, Vt = [],
        qt = /(=)\?(?=&|$)|\?\?/;
    _.ajaxSetup({
        jsonp: "callback",
        jsonpCallback: function() {
            var e = Vt.pop() || _.expando + "_" + _t.guid++;
            return this[e] = !0, e
        }
    }), _.ajaxPrefilter("json jsonp", (function(t, n, i) {
        var a, r, s, o = !1 !== t.jsonp && (qt.test(t.url) ? "url" : "string" == typeof t.data && 0 === (t.contentType || "").indexOf("application/x-www-form-urlencoded") && qt.test(t.data) && "data");
        if (o || "jsonp" === t.dataTypes[0]) return a = t.jsonpCallback = p(t.jsonpCallback) ? t.jsonpCallback() : t.jsonpCallback, o ? t[o] = t[o].replace(qt, "$1" + a) : !1 !== t.jsonp && (t.url += (wt.test(t.url) ? "&" : "?") + t.jsonp + "=" + a), t.converters["script json"] = function() {
            return s || _.error(a + " was not called"), s[0]
        }, t.dataTypes[0] = "json", r = e[a], e[a] = function() {
            s = arguments
        }, i.always((function() {
            void 0 === r ? _(e).removeProp(a) : e[a] = r, t[a] && (t.jsonpCallback = n.jsonpCallback, Vt.push(a)), s && p(r) && r(s[0]), s = r = void 0
        })), "script"
    })), f.createHTMLDocument = ((Wt = m.implementation.createHTMLDocument("").body).innerHTML = "<form></form><form></form>", 2 === Wt.childNodes.length), _.parseHTML = function(e, t, n) {
        return "string" != typeof e ? [] : ("boolean" == typeof t && (n = t, t = !1), t || (f.createHTMLDocument ? ((i = (t = m.implementation.createHTMLDocument("")).createElement("base")).href = m.location.href, t.head.appendChild(i)) : t = m), r = !n && [], (a = T.exec(e)) ? [t.createElement(a[1])] : (a = xe([e], t, r), r && r.length && _(r).remove(), _.merge([], a.childNodes)));
        var i, a, r
    }, _.fn.load = function(e, t, n) {
        var i, a, r, s = this,
            o = e.indexOf(" ");
        return o > -1 && (i = pt(e.slice(o)), e = e.slice(0, o)), p(t) ? (n = t, t = void 0) : t && "object" == typeof t && (a = "POST"), s.length > 0 && _.ajax({
            url: e,
            type: a || "GET",
            dataType: "html",
            data: t
        }).done((function(e) {
            r = arguments, s.html(i ? _("<div>").append(_.parseHTML(e)).find(i) : e)
        })).always(n && function(e, t) {
            s.each((function() {
                n.apply(this, r || [e.responseText, t, e])
            }))
        }), this
    }, _.expr.pseudos.animated = function(e) {
        return _.grep(_.timers, (function(t) {
            return e === t.elem
        })).length
    }, _.offset = {
        setOffset: function(e, t, n) {
            var i, a, r, s, o, l, c = _.css(e, "position"),
                u = _(e),
                d = {};
            "static" === c && (e.style.position = "relative"), o = u.offset(), r = _.css(e, "top"), l = _.css(e, "left"), ("absolute" === c || "fixed" === c) && (r + l).indexOf("auto") > -1 ? (s = (i = u.position()).top, a = i.left) : (s = parseFloat(r) || 0, a = parseFloat(l) || 0), p(t) && (t = t.call(e, n, _.extend({}, o))), null != t.top && (d.top = t.top - o.top + s), null != t.left && (d.left = t.left - o.left + a), "using" in t ? t.using.call(e, d) : u.css(d)
        }
    }, _.fn.extend({
        offset: function(e) {
            if (arguments.length) return void 0 === e ? this : this.each((function(t) {
                _.offset.setOffset(this, e, t)
            }));
            var t, n, i = this[0];
            return i ? i.getClientRects().length ? (t = i.getBoundingClientRect(), n = i.ownerDocument.defaultView, {
                top: t.top + n.pageYOffset,
                left: t.left + n.pageXOffset
            }) : {
                top: 0,
                left: 0
            } : void 0
        },
        position: function() {
            if (this[0]) {
                var e, t, n, i = this[0],
                    a = {
                        top: 0,
                        left: 0
                    };
                if ("fixed" === _.css(i, "position")) t = i.getBoundingClientRect();
                else {
                    for (t = this.offset(), n = i.ownerDocument, e = i.offsetParent || n.documentElement; e && (e === n.body || e === n.documentElement) && "static" === _.css(e, "position");) e = e.parentNode;
                    e && e !== i && 1 === e.nodeType && ((a = _(e).offset()).top += _.css(e, "borderTopWidth", !0), a.left += _.css(e, "borderLeftWidth", !0))
                }
                return {
                    top: t.top - a.top - _.css(i, "marginTop", !0),
                    left: t.left - a.left - _.css(i, "marginLeft", !0)
                }
            }
        },
        offsetParent: function() {
            return this.map((function() {
                for (var e = this.offsetParent; e && "static" === _.css(e, "position");) e = e.offsetParent;
                return e || ie
            }))
        }
    }), _.each({
        scrollLeft: "pageXOffset",
        scrollTop: "pageYOffset"
    }, (function(e, t) {
        var n = "pageYOffset" === t;
        _.fn[e] = function(i) {
            return B(this, (function(e, i, a) {
                var r;
                if (g(e) ? r = e : 9 === e.nodeType && (r = e.defaultView), void 0 === a) return r ? r[t] : e[i];
                r ? r.scrollTo(n ? r.pageXOffset : a, n ? a : r.pageYOffset) : e[i] = a
            }), e, i, arguments.length)
        }
    })), _.each(["top", "left"], (function(e, t) {
        _.cssHooks[t] = Be(f.pixelPosition, (function(e, n) {
            if (n) return n = ze(e, t), Ne.test(n) ? _(e).position()[t] + "px" : n
        }))
    })), _.each({
        Height: "height",
        Width: "width"
    }, (function(e, t) {
        _.each({
            padding: "inner" + e,
            content: t,
            "": "outer" + e
        }, (function(n, i) {
            _.fn[i] = function(a, r) {
                var s = arguments.length && (n || "boolean" != typeof a),
                    o = n || (!0 === a || !0 === r ? "margin" : "border");
                return B(this, (function(t, n, a) {
                    var r;
                    return g(t) ? 0 === i.indexOf("outer") ? t["inner" + e] : t.document.documentElement["client" + e] : 9 === t.nodeType ? (r = t.documentElement, Math.max(t.body["scroll" + e], r["scroll" + e], t.body["offset" + e], r["offset" + e], r["client" + e])) : void 0 === a ? _.css(t, n, o) : _.style(t, n, a, o)
                }), t, s ? a : void 0, s)
            }
        }))
    })), _.each(["ajaxStart", "ajaxStop", "ajaxComplete", "ajaxError", "ajaxSuccess", "ajaxSend"], (function(e, t) {
        _.fn[t] = function(e) {
            return this.on(t, e)
        }
    })), _.fn.extend({
        bind: function(e, t, n) {
            return this.on(e, null, t, n)
        },
        unbind: function(e, t) {
            return this.off(e, null, t)
        },
        delegate: function(e, t, n, i) {
            return this.on(t, e, n, i)
        },
        undelegate: function(e, t, n) {
            return 1 === arguments.length ? this.off(e, "**") : this.off(t, e || "**", n)
        },
        hover: function(e, t) {
            return this.mouseenter(e).mouseleave(t || e)
        }
    }), _.each("blur focus focusin focusout resize scroll click dblclick mousedown mouseup mousemove mouseover mouseout mouseenter mouseleave change select submit keydown keypress keyup contextmenu".split(" "), (function(e, t) {
        _.fn[t] = function(e, n) {
            return arguments.length > 0 ? this.on(t, null, e, n) : this.trigger(t)
        }
    }));
    var Xt = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
    _.proxy = function(e, t) {
        var n, i, r;
        if ("string" == typeof t && (n = e[t], t = e, e = n), p(e)) return i = a.call(arguments, 2), r = function() {
            return e.apply(t || this, i.concat(a.call(arguments)))
        }, r.guid = e.guid = e.guid || _.guid++, r
    }, _.holdReady = function(e) {
        e ? _.readyWait++ : _.ready(!0)
    }, _.isArray = Array.isArray, _.parseJSON = JSON.parse, _.nodeName = A, _.isFunction = p, _.isWindow = g, _.camelCase = X, _.type = b, _.now = Date.now, _.isNumeric = function(e) {
        var t = _.type(e);
        return ("number" === t || "string" === t) && !isNaN(e - parseFloat(e))
    }, _.trim = function(e) {
        return null == e ? "" : (e + "").replace(Xt, "")
    }, "function" == typeof define && define.amd && define("jquery", [], (function() {
        return _
    }));
    var Ut = e.jQuery,
        $t = e.$;
    return _.noConflict = function(t) {
        return e.$ === _ && (e.$ = $t), t && e.jQuery === _ && (e.jQuery = Ut), _
    }, void 0 === t && (e.jQuery = e.$ = _), _
})),function(e) {
    "function" == typeof define && define.amd ? define(["jquery"], e) : "object" == typeof module && module.exports ? module.exports = function(t, n) {
        return void 0 === n && (n = "undefined" != typeof window ? require("jquery") : require("jquery")(t)), e(n), n
    } : e(jQuery)
}((function(e) {
    var t = function() {
            if (e && e.fn && e.fn.select2 && e.fn.select2.amd) var t = e.fn.select2.amd;
            var n;
            return function() {
                    /**
                     * @license almond 0.3.3 Copyright jQuery Foundation and other contributors.
                     * Released under MIT license, http://github.com/requirejs/almond/LICENSE
                     */
                    var e, n, i;
                    t && t.requirejs || (t ? n = t : t = {}, function(t) {
                        var a, r, s, o, l = {},
                            c = {},
                            u = {},
                            d = {},
                            h = Object.prototype.hasOwnProperty,
                            f = [].slice,
                            p = /\.js$/;

                        function g(e, t) {
                            return h.call(e, t)
                        }

                        function m(e, t) {
                            var n, i, a, r, s, o, l, c, d, h, f, g = t && t.split("/"),
                                m = u.map,
                                v = m && m["*"] || {};
                            if (e) {
                                for (s = (e = e.split("/")).length - 1, u.nodeIdCompat && p.test(e[s]) && (e[s] = e[s].replace(p, "")), "." === e[0].charAt(0) && g && (e = g.slice(0, g.length - 1).concat(e)), d = 0; d < e.length; d++)
                                    if ("." === (f = e[d])) e.splice(d, 1), d -= 1;
                                    else if (".." === f) {
                                    if (0 === d || 1 === d && ".." === e[2] || ".." === e[d - 1]) continue;
                                    d > 0 && (e.splice(d - 1, 2), d -= 2)
                                }
                                e = e.join("/")
                            }
                            if ((g || v) && m) {
                                for (d = (n = e.split("/")).length; d > 0; d -= 1) {
                                    if (i = n.slice(0, d).join("/"), g)
                                        for (h = g.length; h > 0; h -= 1)
                                            if ((a = m[g.slice(0, h).join("/")]) && (a = a[i])) {
                                                r = a, o = d;
                                                break
                                            } if (r) break;
                                    !l && v && v[i] && (l = v[i], c = d)
                                }!r && l && (r = l, o = c), r && (n.splice(0, o, r), e = n.join("/"))
                            }
                            return e
                        }

                        function v(e, n) {
                            return function() {
                                var i = f.call(arguments, 0);
                                return "string" != typeof i[0] && 1 === i.length && i.push(null), r.apply(t, i.concat([e, n]))
                            }
                        }

                        function y(e) {
                            return function(t) {
                                l[e] = t
                            }
                        }

                        function b(e) {
                            if (g(c, e)) {
                                var n = c[e];
                                delete c[e], d[e] = !0, a.apply(t, n)
                            }
                            if (!g(l, e) && !g(d, e)) throw new Error("No " + e);
                            return l[e]
                        }

                        function x(e) {
                            var t, n = e ? e.indexOf("!") : -1;
                            return n > -1 && (t = e.substring(0, n), e = e.substring(n + 1, e.length)), [t, e]
                        }

                        function _(e) {
                            return e ? x(e) : []
                        }

                        function w(e) {
                            return function() {
                                return u && u.config && u.config[e] || {}
                            }
                        }
                        s = function(e, t) {
                            var n, i, a = x(e),
                                r = a[0],
                                s = t[1];
                            return e = a[1], r && (n = b(r = m(r, s))), r ? e = n && n.normalize ? n.normalize(e, (i = s, function(e) {
                                return m(e, i)
                            })) : m(e, s) : (r = (a = x(e = m(e, s)))[0], e = a[1], r && (n = b(r))), {
                                f: r ? r + "!" + e : e,
                                n: e,
                                pr: r,
                                p: n
                            }
                        }, o = {
                            require: function(e) {
                                return v(e)
                            },
                            exports: function(e) {
                                var t = l[e];
                                return void 0 !== t ? t : l[e] = {}
                            },
                            module: function(e) {
                                return {
                                    id: e,
                                    uri: "",
                                    exports: l[e],
                                    config: w(e)
                                }
                            }
                        }, a = function(e, n, i, a) {
                            var r, u, h, f, p, m, x, w = [],
                                k = typeof i;
                            if (m = _(a = a || e), "undefined" === k || "function" === k) {
                                for (n = !n.length && i.length ? ["require", "exports", "module"] : n, p = 0; p < n.length; p += 1)
                                    if ("require" === (u = (f = s(n[p], m)).f)) w[p] = o.require(e);
                                    else if ("exports" === u) w[p] = o.exports(e), x = !0;
                                else if ("module" === u) r = w[p] = o.module(e);
                                else if (g(l, u) || g(c, u) || g(d, u)) w[p] = b(u);
                                else {
                                    if (!f.p) throw new Error(e + " missing " + u);
                                    f.p.load(f.n, v(a, !0), y(u), {}), w[p] = l[u]
                                }
                                h = i ? i.apply(l[e], w) : void 0, e && (r && r.exports !== t && r.exports !== l[e] ? l[e] = r.exports : h === t && x || (l[e] = h))
                            } else e && (l[e] = i)
                        }, e = n = r = function(e, n, i, l, c) {
                            if ("string" == typeof e) return o[e] ? o[e](n) : b(s(e, _(n)).f);
                            if (!e.splice) {
                                if ((u = e).deps && r(u.deps, u.callback), !n) return;
                                n.splice ? (e = n, n = i, i = null) : e = t
                            }
                            return n = n || function() {}, "function" == typeof i && (i = l, l = c), l ? a(t, e, n, i) : setTimeout((function() {
                                a(t, e, n, i)
                            }), 4), r
                        }, r.config = function(e) {
                            return r(e)
                        }, e._defined = l, (i = function(e, t, n) {
                            if ("string" != typeof e) throw new Error("See almond README: incorrect module build, no module name");
                            t.splice || (n = t, t = []), g(l, e) || g(c, e) || (c[e] = [e, t, n])
                        }).amd = {
                            jQuery: !0
                        }
                    }(), t.requirejs = e, t.require = n, t.define = i)
                }(), t.define("almond", (function() {})), t.define("jquery", [], (function() {
                    var t = e || $;
                    return null == t && console && console.error && console.error("Select2: An instance of jQuery or a jQuery-compatible library was not found. Make sure that you are including jQuery before Select2 on your web page."), t
                })), t.define("select2/utils", ["jquery"], (function(e) {
                    var t = {};

                    function n(e) {
                        var t = e.prototype,
                            n = [];
                        for (var i in t) {
                            "function" == typeof t[i] && ("constructor" !== i && n.push(i))
                        }
                        return n
                    }
                    t.Extend = function(e, t) {
                        var n = {}.hasOwnProperty;

                        function i() {
                            this.constructor = e
                        }
                        for (var a in t) n.call(t, a) && (e[a] = t[a]);
                        return i.prototype = t.prototype, e.prototype = new i, e.__super__ = t.prototype, e
                    }, t.Decorate = function(e, t) {
                        var i = n(t),
                            a = n(e);

                        function r() {
                            var n = Array.prototype.unshift,
                                i = t.prototype.constructor.length,
                                a = e.prototype.constructor;
                            i > 0 && (n.call(arguments, e.prototype.constructor), a = t.prototype.constructor), a.apply(this, arguments)
                        }
                        t.displayName = e.displayName, r.prototype = new function() {
                            this.constructor = r
                        };
                        for (var s = 0; s < a.length; s++) {
                            var o = a[s];
                            r.prototype[o] = e.prototype[o]
                        }
                        for (var l = function(e) {
                                var n = function() {};
                                e in r.prototype && (n = r.prototype[e]);
                                var i = t.prototype[e];
                                return function() {
                                    var e = Array.prototype.unshift;
                                    return e.call(arguments, n), i.apply(this, arguments)
                                }
                            }, c = 0; c < i.length; c++) {
                            var u = i[c];
                            r.prototype[u] = l(u)
                        }
                        return r
                    };
                    var i = function() {
                        this.listeners = {}
                    };
                    i.prototype.on = function(e, t) {
                        this.listeners = this.listeners || {}, e in this.listeners ? this.listeners[e].push(t) : this.listeners[e] = [t]
                    }, i.prototype.trigger = function(e) {
                        var t = Array.prototype.slice,
                            n = t.call(arguments, 1);
                        this.listeners = this.listeners || {}, null == n && (n = []), 0 === n.length && n.push({}), n[0]._type = e, e in this.listeners && this.invoke(this.listeners[e], t.call(arguments, 1)), "*" in this.listeners && this.invoke(this.listeners["*"], arguments)
                    }, i.prototype.invoke = function(e, t) {
                        for (var n = 0, i = e.length; n < i; n++) e[n].apply(this, t)
                    }, t.Observable = i, t.generateChars = function(e) {
                        for (var t = "", n = 0; n < e; n++) {
                            t += Math.floor(36 * Math.random()).toString(36)
                        }
                        return t
                    }, t.bind = function(e, t) {
                        return function() {
                            e.apply(t, arguments)
                        }
                    }, t._convertData = function(e) {
                        for (var t in e) {
                            var n = t.split("-"),
                                i = e;
                            if (1 !== n.length) {
                                for (var a = 0; a < n.length; a++) {
                                    var r = n[a];
                                    (r = r.substring(0, 1).toLowerCase() + r.substring(1)) in i || (i[r] = {}), a == n.length - 1 && (i[r] = e[t]), i = i[r]
                                }
                                delete e[t]
                            }
                        }
                        return e
                    }, t.hasScroll = function(t, n) {
                        var i = e(n),
                            a = n.style.overflowX,
                            r = n.style.overflowY;
                        return (a !== r || "hidden" !== r && "visible" !== r) && ("scroll" === a || "scroll" === r || (i.innerHeight() < n.scrollHeight || i.innerWidth() < n.scrollWidth))
                    }, t.escapeMarkup = function(e) {
                        var t = {
                            "\\": "&#92;",
                            "&": "&amp;",
                            "<": "&lt;",
                            ">": "&gt;",
                            '"': "&quot;",
                            "'": "&#39;",
                            "/": "&#47;"
                        };
                        return "string" != typeof e ? e : String(e).replace(/[&<>"'\/\\]/g, (function(e) {
                            return t[e]
                        }))
                    }, t.__cache = {};
                    var a = 0;
                    return t.GetUniqueElementId = function(e) {
                        var n = e.getAttribute("data-select2-id");
                        return null != n || (n = e.id ? "select2-data-" + e.id : "select2-data-" + (++a).toString() + "-" + t.generateChars(4), e.setAttribute("data-select2-id", n)), n
                    }, t.StoreData = function(e, n, i) {
                        var a = t.GetUniqueElementId(e);
                        t.__cache[a] || (t.__cache[a] = {}), t.__cache[a][n] = i
                    }, t.GetData = function(n, i) {
                        var a = t.GetUniqueElementId(n);
                        return i ? t.__cache[a] && null != t.__cache[a][i] ? t.__cache[a][i] : e(n).data(i) : t.__cache[a]
                    }, t.RemoveData = function(e) {
                        var n = t.GetUniqueElementId(e);
                        null != t.__cache[n] && delete t.__cache[n], e.removeAttribute("data-select2-id")
                    }, t.copyNonInternalCssClasses = function(e, t) {
                        var n = e.getAttribute("class").trim().split(/\s+/);
                        n = n.filter((function(e) {
                            return 0 === e.indexOf("select2-")
                        }));
                        var i = t.getAttribute("class").trim().split(/\s+/);
                        i = i.filter((function(e) {
                            return 0 !== e.indexOf("select2-")
                        }));
                        var a = n.concat(i);
                        e.setAttribute("class", a.join(" "))
                    }, t
                })), t.define("select2/results", ["jquery", "./utils"], (function(e, t) {
                    function n(e, t, i) {
                        this.$element = e, this.data = i, this.options = t, n.__super__.constructor.call(this)
                    }
                    return t.Extend(n, t.Observable), n.prototype.render = function() {
                        var t = e('<ul class="select2-results__options" role="listbox"></ul>');
                        return this.options.get("multiple") && t.attr("aria-multiselectable", "true"), this.$results = t, t
                    }, n.prototype.clear = function() {
                        this.$results.empty()
                    }, n.prototype.displayMessage = function(t) {
                        var n = this.options.get("escapeMarkup");
                        this.clear(), this.hideLoading();
                        var i = e('<li role="alert" aria-live="assertive" class="select2-results__option"></li>'),
                            a = this.options.get("translations").get(t.message);
                        i.append(n(a(t.args))), i[0].className += " select2-results__message", this.$results.append(i)
                    }, n.prototype.hideMessages = function() {
                        this.$results.find(".select2-results__message").remove()
                    }, n.prototype.append = function(e) {
                        this.hideLoading();
                        var t = [];
                        if (null != e.results && 0 !== e.results.length) {
                            e.results = this.sort(e.results);
                            for (var n = 0; n < e.results.length; n++) {
                                var i = e.results[n],
                                    a = this.option(i);
                                t.push(a)
                            }
                            this.$results.append(t)
                        } else 0 === this.$results.children().length && this.trigger("results:message", {
                            message: "noResults"
                        })
                    }, n.prototype.position = function(e, t) {
                        t.find(".select2-results").append(e)
                    }, n.prototype.sort = function(e) {
                        return this.options.get("sorter")(e)
                    }, n.prototype.highlightFirstItem = function() {
                        var e = this.$results.find(".select2-results__option--selectable"),
                            t = e.filter(".select2-results__option--selected");
                        t.length > 0 ? t.first().trigger("mouseenter") : e.first().trigger("mouseenter"), this.ensureHighlightVisible()
                    }, n.prototype.setClasses = function() {
                        var n = this;
                        this.data.current((function(i) {
                            var a = i.map((function(e) {
                                return e.id.toString()
                            }));
                            n.$results.find(".select2-results__option--selectable").each((function() {
                                var n = e(this),
                                    i = t.GetData(this, "data"),
                                    r = "" + i.id;
                                null != i.element && i.element.selected || null == i.element && a.indexOf(r) > -1 ? (this.classList.add("select2-results__option--selected"), n.attr("aria-selected", "true")) : (this.classList.remove("select2-results__option--selected"), n.attr("aria-selected", "false"))
                            }))
                        }))
                    }, n.prototype.showLoading = function(e) {
                        this.hideLoading();
                        var t = {
                                disabled: !0,
                                loading: !0,
                                text: this.options.get("translations").get("searching")(e)
                            },
                            n = this.option(t);
                        n.className += " loading-results", this.$results.prepend(n)
                    }, n.prototype.hideLoading = function() {
                        this.$results.find(".loading-results").remove()
                    }, n.prototype.option = function(n) {
                        var i = document.createElement("li");
                        i.classList.add("select2-results__option"), i.classList.add("select2-results__option--selectable");
                        var a = {
                                role: "option"
                            },
                            r = window.Element.prototype.matches || window.Element.prototype.msMatchesSelector || window.Element.prototype.webkitMatchesSelector;
                        for (var s in (null != n.element && r.call(n.element, ":disabled") || null == n.element && n.disabled) && (a["aria-disabled"] = "true", i.classList.remove("select2-results__option--selectable"), i.classList.add("select2-results__option--disabled")), null == n.id && i.classList.remove("select2-results__option--selectable"), null != n._resultId && (i.id = n._resultId), n.title && (i.title = n.title), n.children && (a.role = "group", a["aria-label"] = n.text, i.classList.remove("select2-results__option--selectable"), i.classList.add("select2-results__option--group")), a) {
                            var o = a[s];
                            i.setAttribute(s, o)
                        }
                        if (n.children) {
                            var l = e(i),
                                c = document.createElement("strong");
                            c.className = "select2-results__group", this.template(n, c);
                            for (var u = [], d = 0; d < n.children.length; d++) {
                                var h = n.children[d],
                                    f = this.option(h);
                                u.push(f)
                            }
                            var p = e("<ul></ul>", {
                                class: "select2-results__options select2-results__options--nested",
                                role: "none"
                            });
                            p.append(u), l.append(c), l.append(p)
                        } else this.template(n, i);
                        return t.StoreData(i, "data", n), i
                    }, n.prototype.bind = function(n, i) {
                        var a = this,
                            r = n.id + "-results";
                        this.$results.attr("id", r), n.on("results:all", (function(e) {
                            a.clear(), a.append(e.data), n.isOpen() && (a.setClasses(), a.highlightFirstItem())
                        })), n.on("results:append", (function(e) {
                            a.append(e.data), n.isOpen() && a.setClasses()
                        })), n.on("query", (function(e) {
                            a.hideMessages(), a.showLoading(e)
                        })), n.on("select", (function() {
                            n.isOpen() && (a.setClasses(), a.options.get("scrollAfterSelect") && a.highlightFirstItem())
                        })), n.on("unselect", (function() {
                            n.isOpen() && (a.setClasses(), a.options.get("scrollAfterSelect") && a.highlightFirstItem())
                        })), n.on("open", (function() {
                            a.$results.attr("aria-expanded", "true"), a.$results.attr("aria-hidden", "false"), a.setClasses(), a.ensureHighlightVisible()
                        })), n.on("close", (function() {
                            a.$results.attr("aria-expanded", "false"), a.$results.attr("aria-hidden", "true"), a.$results.removeAttr("aria-activedescendant")
                        })), n.on("results:toggle", (function() {
                            var e = a.getHighlightedResults();
                            0 !== e.length && e.trigger("mouseup")
                        })), n.on("results:select", (function() {
                            var e = a.getHighlightedResults();
                            if (0 !== e.length) {
                                var n = t.GetData(e[0], "data");
                                e.hasClass("select2-results__option--selected") ? a.trigger("close", {}) : a.trigger("select", {
                                    data: n
                                })
                            }
                        })), n.on("results:previous", (function() {
                            var e = a.getHighlightedResults(),
                                t = a.$results.find(".select2-results__option--selectable"),
                                n = t.index(e);
                            if (!(n <= 0)) {
                                var i = n - 1;
                                0 === e.length && (i = 0);
                                var r = t.eq(i);
                                r.trigger("mouseenter");
                                var s = a.$results.offset().top,
                                    o = r.offset().top,
                                    l = a.$results.scrollTop() + (o - s);
                                0 === i ? a.$results.scrollTop(0) : o - s < 0 && a.$results.scrollTop(l)
                            }
                        })), n.on("results:next", (function() {
                            var e = a.getHighlightedResults(),
                                t = a.$results.find(".select2-results__option--selectable"),
                                n = t.index(e) + 1;
                            if (!(n >= t.length)) {
                                var i = t.eq(n);
                                i.trigger("mouseenter");
                                var r = a.$results.offset().top + a.$results.outerHeight(!1),
                                    s = i.offset().top + i.outerHeight(!1),
                                    o = a.$results.scrollTop() + s - r;
                                0 === n ? a.$results.scrollTop(0) : s > r && a.$results.scrollTop(o)
                            }
                        })), n.on("results:focus", (function(e) {
                            e.element[0].classList.add("select2-results__option--highlighted"), e.element[0].setAttribute("aria-selected", "true")
                        })), n.on("results:message", (function(e) {
                            a.displayMessage(e)
                        })), e.fn.mousewheel && this.$results.on("mousewheel", (function(e) {
                            var t = a.$results.scrollTop(),
                                n = a.$results.get(0).scrollHeight - t + e.deltaY,
                                i = e.deltaY > 0 && t - e.deltaY <= 0,
                                r = e.deltaY < 0 && n <= a.$results.height();
                            i ? (a.$results.scrollTop(0), e.preventDefault(), e.stopPropagation()) : r && (a.$results.scrollTop(a.$results.get(0).scrollHeight - a.$results.height()), e.preventDefault(), e.stopPropagation())
                        })), this.$results.on("mouseup", ".select2-results__option--selectable", (function(n) {
                            var i = e(this),
                                r = t.GetData(this, "data");
                            i.hasClass("select2-results__option--selected") ? a.options.get("multiple") ? a.trigger("unselect", {
                                originalEvent: n,
                                data: r
                            }) : a.trigger("close", {}) : a.trigger("select", {
                                originalEvent: n,
                                data: r
                            })
                        })), this.$results.on("mouseenter", ".select2-results__option--selectable", (function(n) {
                            var i = t.GetData(this, "data");
                            a.getHighlightedResults().removeClass("select2-results__option--highlighted").attr("aria-selected", "false"), a.trigger("results:focus", {
                                data: i,
                                element: e(this)
                            })
                        }))
                    }, n.prototype.getHighlightedResults = function() {
                        return this.$results.find(".select2-results__option--highlighted")
                    }, n.prototype.destroy = function() {
                        this.$results.remove()
                    }, n.prototype.ensureHighlightVisible = function() {
                        var e = this.getHighlightedResults();
                        if (0 !== e.length) {
                            var t = this.$results.find(".select2-results__option--selectable").index(e),
                                n = this.$results.offset().top,
                                i = e.offset().top,
                                a = this.$results.scrollTop() + (i - n),
                                r = i - n;
                            a -= 2 * e.outerHeight(!1), t <= 2 ? this.$results.scrollTop(0) : (r > this.$results.outerHeight() || r < 0) && this.$results.scrollTop(a)
                        }
                    }, n.prototype.template = function(t, n) {
                        var i = this.options.get("templateResult"),
                            a = this.options.get("escapeMarkup"),
                            r = i(t, n);
                        null == r ? n.style.display = "none" : "string" == typeof r ? n.innerHTML = a(r) : e(n).append(r)
                    }, n
                })), t.define("select2/keys", [], (function() {
                    return {
                        BACKSPACE: 8,
                        TAB: 9,
                        ENTER: 13,
                        SHIFT: 16,
                        CTRL: 17,
                        ALT: 18,
                        ESC: 27,
                        SPACE: 32,
                        PAGE_UP: 33,
                        PAGE_DOWN: 34,
                        END: 35,
                        HOME: 36,
                        LEFT: 37,
                        UP: 38,
                        RIGHT: 39,
                        DOWN: 40,
                        DELETE: 46
                    }
                })), t.define("select2/selection/base", ["jquery", "../utils", "../keys"], (function(e, t, n) {
                    function i(e, t) {
                        this.$element = e, this.options = t, i.__super__.constructor.call(this)
                    }
                    return t.Extend(i, t.Observable), i.prototype.render = function() {
                        var n = e('<span class="select2-selection" role="combobox"  aria-haspopup="true" aria-expanded="false"></span>');
                        return this._tabindex = 0, null != t.GetData(this.$element[0], "old-tabindex") ? this._tabindex = t.GetData(this.$element[0], "old-tabindex") : null != this.$element.attr("tabindex") && (this._tabindex = this.$element.attr("tabindex")), n.attr("title", this.$element.attr("title")), n.attr("tabindex", this._tabindex), n.attr("aria-disabled", "false"), this.$selection = n, n
                    }, i.prototype.bind = function(e, t) {
                        var i = this,
                            a = e.id + "-results";
                        this.container = e, this.$selection.on("focus", (function(e) {
                            i.trigger("focus", e)
                        })), this.$selection.on("blur", (function(e) {
                            i._handleBlur(e)
                        })), this.$selection.on("keydown", (function(e) {
                            i.trigger("keypress", e), e.which === n.SPACE && e.preventDefault()
                        })), e.on("results:focus", (function(e) {
                            i.$selection.attr("aria-activedescendant", e.data._resultId)
                        })), e.on("selection:update", (function(e) {
                            i.update(e.data)
                        })), e.on("open", (function() {
                            i.$selection.attr("aria-expanded", "true"), i.$selection.attr("aria-owns", a), i._attachCloseHandler(e)
                        })), e.on("close", (function() {
                            i.$selection.attr("aria-expanded", "false"), i.$selection.removeAttr("aria-activedescendant"), i.$selection.removeAttr("aria-owns"), i.$selection.trigger("focus"), i._detachCloseHandler(e)
                        })), e.on("enable", (function() {
                            i.$selection.attr("tabindex", i._tabindex), i.$selection.attr("aria-disabled", "false")
                        })), e.on("disable", (function() {
                            i.$selection.attr("tabindex", "-1"), i.$selection.attr("aria-disabled", "true")
                        }))
                    }, i.prototype._handleBlur = function(t) {
                        var n = this;
                        window.setTimeout((function() {
                            document.activeElement == n.$selection[0] || e.contains(n.$selection[0], document.activeElement) || n.trigger("blur", t)
                        }), 1)
                    }, i.prototype._attachCloseHandler = function(n) {
                        e(document.body).on("mousedown.select2." + n.id, (function(n) {
                            var i = e(n.target).closest(".select2");
                            e(".select2.select2-container--open").each((function() {
                                this != i[0] && t.GetData(this, "element").select2("close")
                            }))
                        }))
                    }, i.prototype._detachCloseHandler = function(t) {
                        e(document.body).off("mousedown.select2." + t.id)
                    }, i.prototype.position = function(e, t) {
                        t.find(".selection").append(e)
                    }, i.prototype.destroy = function() {
                        this._detachCloseHandler(this.container)
                    }, i.prototype.update = function(e) {
                        throw new Error("The `update` method must be defined in child classes.")
                    }, i.prototype.isEnabled = function() {
                        return !this.isDisabled()
                    }, i.prototype.isDisabled = function() {
                        return this.options.get("disabled")
                    }, i
                })), t.define("select2/selection/single", ["jquery", "./base", "../utils", "../keys"], (function(e, t, n, i) {
                    function a() {
                        a.__super__.constructor.apply(this, arguments)
                    }
                    return n.Extend(a, t), a.prototype.render = function() {
                        var e = a.__super__.render.call(this);
                        return e[0].classList.add("select2-selection--single"), e.html('<span class="select2-selection__rendered"></span><span class="select2-selection__arrow" role="presentation"><b role="presentation"></b></span>'), e
                    }, a.prototype.bind = function(e, t) {
                        var n = this;
                        a.__super__.bind.apply(this, arguments);
                        var i = e.id + "-container";
                        this.$selection.find(".select2-selection__rendered").attr("id", i).attr("role", "textbox").attr("aria-readonly", "true"), this.$selection.attr("aria-labelledby", i), this.$selection.attr("aria-controls", i), this.$selection.on("mousedown", (function(e) {
                            1 === e.which && n.trigger("toggle", {
                                originalEvent: e
                            })
                        })), this.$selection.on("focus", (function(e) {})), this.$selection.on("blur", (function(e) {})), e.on("focus", (function(t) {
                            e.isOpen() || n.$selection.trigger("focus")
                        }))
                    }, a.prototype.clear = function() {
                        var e = this.$selection.find(".select2-selection__rendered");
                        e.empty(), e.removeAttr("title")
                    }, a.prototype.display = function(e, t) {
                        var n = this.options.get("templateSelection");
                        return this.options.get("escapeMarkup")(n(e, t))
                    }, a.prototype.selectionContainer = function() {
                        return e("<span></span>")
                    }, a.prototype.update = function(e) {
                        if (0 !== e.length) {
                            var t = e[0],
                                n = this.$selection.find(".select2-selection__rendered"),
                                i = this.display(t, n);
                            n.empty().append(i);
                            var a = t.title || t.text;
                            a ? n.attr("title", a) : n.removeAttr("title")
                        } else this.clear()
                    }, a
                })), t.define("select2/selection/multiple", ["jquery", "./base", "../utils"], (function(e, t, n) {
                    function i(e, t) {
                        i.__super__.constructor.apply(this, arguments)
                    }
                    return n.Extend(i, t), i.prototype.render = function() {
                        var e = i.__super__.render.call(this);
                        return e[0].classList.add("select2-selection--multiple"), e.html('<ul class="select2-selection__rendered"></ul>'), e
                    }, i.prototype.bind = function(t, a) {
                        var r = this;
                        i.__super__.bind.apply(this, arguments);
                        var s = t.id + "-container";
                        this.$selection.find(".select2-selection__rendered").attr("id", s), this.$selection.on("click", (function(e) {
                            r.trigger("toggle", {
                                originalEvent: e
                            })
                        })), this.$selection.on("click", ".select2-selection__choice__remove", (function(t) {
                            if (!r.isDisabled()) {
                                var i = e(this).parent(),
                                    a = n.GetData(i[0], "data");
                                r.trigger("unselect", {
                                    originalEvent: t,
                                    data: a
                                })
                            }
                        })), this.$selection.on("keydown", ".select2-selection__choice__remove", (function(e) {
                            r.isDisabled() || e.stopPropagation()
                        }))
                    }, i.prototype.clear = function() {
                        var e = this.$selection.find(".select2-selection__rendered");
                        e.empty(), e.removeAttr("title")
                    }, i.prototype.display = function(e, t) {
                        var n = this.options.get("templateSelection");
                        return this.options.get("escapeMarkup")(n(e, t))
                    }, i.prototype.selectionContainer = function() {
                        return e('<li class="select2-selection__choice"><button type="button" class="select2-selection__choice__remove" tabindex="-1"><span aria-hidden="true">&times;</span></button><span class="select2-selection__choice__display"></span></li>')
                    }, i.prototype.update = function(e) {
                        if (this.clear(), 0 !== e.length) {
                            for (var t = [], i = this.$selection.find(".select2-selection__rendered").attr("id") + "-choice-", a = 0; a < e.length; a++) {
                                var r = e[a],
                                    s = this.selectionContainer(),
                                    o = this.display(r, s),
                                    l = i + n.generateChars(4) + "-";
                                r.id ? l += r.id : l += n.generateChars(4), s.find(".select2-selection__choice__display").append(o).attr("id", l);
                                var c = r.title || r.text;
                                c && s.attr("title", c);
                                var u = this.options.get("translations").get("removeItem"),
                                    d = s.find(".select2-selection__choice__remove");
                                d.attr("title", u()), d.attr("aria-label", u()), d.attr("aria-describedby", l), n.StoreData(s[0], "data", r), t.push(s)
                            }
                            this.$selection.find(".select2-selection__rendered").append(t)
                        }
                    }, i
                })), t.define("select2/selection/placeholder", [], (function() {
                    function e(e, t, n) {
                        this.placeholder = this.normalizePlaceholder(n.get("placeholder")), e.call(this, t, n)
                    }
                    return e.prototype.normalizePlaceholder = function(e, t) {
                        return "string" == typeof t && (t = {
                            id: "",
                            text: t
                        }), t
                    }, e.prototype.createPlaceholder = function(e, t) {
                        var n = this.selectionContainer();
                        n.html(this.display(t)), n[0].classList.add("select2-selection__placeholder"), n[0].classList.remove("select2-selection__choice");
                        var i = t.title || t.text || n.text();
                        return this.$selection.find(".select2-selection__rendered").attr("title", i), n
                    }, e.prototype.update = function(e, t) {
                        var n = 1 == t.length && t[0].id != this.placeholder.id;
                        if (t.length > 1 || n) return e.call(this, t);
                        this.clear();
                        var i = this.createPlaceholder(this.placeholder);
                        this.$selection.find(".select2-selection__rendered").append(i)
                    }, e
                })), t.define("select2/selection/allowClear", ["jquery", "../keys", "../utils"], (function(e, t, n) {
                    function i() {}
                    return i.prototype.bind = function(e, t, n) {
                        var i = this;
                        e.call(this, t, n), null == this.placeholder && this.options.get("debug") && window.console && console.error && console.error("Select2: The `allowClear` option should be used in combination with the `placeholder` option."), this.$selection.on("mousedown", ".select2-selection__clear", (function(e) {
                            i._handleClear(e)
                        })), t.on("keypress", (function(e) {
                            i._handleKeyboardClear(e, t)
                        }))
                    }, i.prototype._handleClear = function(e, t) {
                        if (!this.isDisabled()) {
                            var i = this.$selection.find(".select2-selection__clear");
                            if (0 !== i.length) {
                                t.stopPropagation();
                                var a = n.GetData(i[0], "data"),
                                    r = this.$element.val();
                                this.$element.val(this.placeholder.id);
                                var s = {
                                    data: a
                                };
                                if (this.trigger("clear", s), s.prevented) this.$element.val(r);
                                else {
                                    for (var o = 0; o < a.length; o++)
                                        if (s = {
                                                data: a[o]
                                            }, this.trigger("unselect", s), s.prevented) return void this.$element.val(r);
                                    this.$element.trigger("input").trigger("change"), this.trigger("toggle", {})
                                }
                            }
                        }
                    }, i.prototype._handleKeyboardClear = function(e, n, i) {
                        i.isOpen() || n.which != t.DELETE && n.which != t.BACKSPACE || this._handleClear(n)
                    }, i.prototype.update = function(t, i) {
                        if (t.call(this, i), this.$selection.find(".select2-selection__clear").remove(), this.$selection[0].classList.remove("select2-selection--clearable"), !(this.$selection.find(".select2-selection__placeholder").length > 0 || 0 === i.length)) {
                            var a = this.$selection.find(".select2-selection__rendered").attr("id"),
                                r = this.options.get("translations").get("removeAllItems"),
                                s = e('<button type="button" class="select2-selection__clear" tabindex="-1"><span aria-hidden="true">&times;</span></button>');
                            s.attr("title", r()), s.attr("aria-label", r()), s.attr("aria-describedby", a), n.StoreData(s[0], "data", i), this.$selection.prepend(s), this.$selection[0].classList.add("select2-selection--clearable")
                        }
                    }, i
                })), t.define("select2/selection/search", ["jquery", "../utils", "../keys"], (function(e, t, n) {
                    function i(e, t, n) {
                        e.call(this, t, n)
                    }
                    return i.prototype.render = function(t) {
                        var n = this.options.get("translations").get("search"),
                            i = e('<span class="select2-search select2-search--inline"><textarea class="select2-search__field" type="search" tabindex="-1" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" ></textarea></span>');
                        this.$searchContainer = i, this.$search = i.find("textarea"), this.$search.prop("autocomplete", this.options.get("autocomplete")), this.$search.attr("aria-label", n());
                        var a = t.call(this);
                        return this._transferTabIndex(), a.append(this.$searchContainer), a
                    }, i.prototype.bind = function(e, i, a) {
                        var r = this,
                            s = i.id + "-results",
                            o = i.id + "-container";
                        e.call(this, i, a), r.$search.attr("aria-describedby", o), i.on("open", (function() {
                            r.$search.attr("aria-controls", s), r.$search.trigger("focus")
                        })), i.on("close", (function() {
                            r.$search.val(""), r.resizeSearch(), r.$search.removeAttr("aria-controls"), r.$search.removeAttr("aria-activedescendant"), r.$search.trigger("focus")
                        })), i.on("enable", (function() {
                            r.$search.prop("disabled", !1), r._transferTabIndex()
                        })), i.on("disable", (function() {
                            r.$search.prop("disabled", !0)
                        })), i.on("focus", (function(e) {
                            r.$search.trigger("focus")
                        })), i.on("results:focus", (function(e) {
                            e.data._resultId ? r.$search.attr("aria-activedescendant", e.data._resultId) : r.$search.removeAttr("aria-activedescendant")
                        })), this.$selection.on("focusin", ".select2-search--inline", (function(e) {
                            r.trigger("focus", e)
                        })), this.$selection.on("focusout", ".select2-search--inline", (function(e) {
                            r._handleBlur(e)
                        })), this.$selection.on("keydown", ".select2-search--inline", (function(e) {
                            if (e.stopPropagation(), r.trigger("keypress", e), r._keyUpPrevented = e.isDefaultPrevented(), e.which === n.BACKSPACE && "" === r.$search.val()) {
                                var i = r.$selection.find(".select2-selection__choice").last();
                                if (i.length > 0) {
                                    var a = t.GetData(i[0], "data");
                                    r.searchRemoveChoice(a), e.preventDefault()
                                }
                            }
                        })), this.$selection.on("click", ".select2-search--inline", (function(e) {
                            r.$search.val() && e.stopPropagation()
                        }));
                        var l = document.documentMode,
                            c = l && l <= 11;
                        this.$selection.on("input.searchcheck", ".select2-search--inline", (function(e) {
                            c ? r.$selection.off("input.search input.searchcheck") : r.$selection.off("keyup.search")
                        })), this.$selection.on("keyup.search input.search", ".select2-search--inline", (function(e) {
                            if (c && "input" === e.type) r.$selection.off("input.search input.searchcheck");
                            else {
                                var t = e.which;
                                t != n.SHIFT && t != n.CTRL && t != n.ALT && t != n.TAB && r.handleSearch(e)
                            }
                        }))
                    }, i.prototype._transferTabIndex = function(e) {
                        this.$search.attr("tabindex", this.$selection.attr("tabindex")), this.$selection.attr("tabindex", "-1")
                    }, i.prototype.createPlaceholder = function(e, t) {
                        this.$search.attr("placeholder", t.text)
                    }, i.prototype.update = function(e, t) {
                        var n = this.$search[0] == document.activeElement;
                        this.$search.attr("placeholder", ""), e.call(this, t), this.resizeSearch(), n && this.$search.trigger("focus")
                    }, i.prototype.handleSearch = function() {
                        if (this.resizeSearch(), !this._keyUpPrevented) {
                            var e = this.$search.val();
                            this.trigger("query", {
                                term: e
                            })
                        }
                        this._keyUpPrevented = !1
                    }, i.prototype.searchRemoveChoice = function(e, t) {
                        this.trigger("unselect", {
                            data: t
                        }), this.$search.val(t.text), this.handleSearch()
                    }, i.prototype.resizeSearch = function() {
                        this.$search.css("width", "25px");
                        var e = "100%";
                        "" === this.$search.attr("placeholder") && (e = .75 * (this.$search.val().length + 1) + "em");
                        this.$search.css("width", e)
                    }, i
                })), t.define("select2/selection/selectionCss", ["../utils"], (function(e) {
                    function t() {}
                    return t.prototype.render = function(t) {
                        var n = t.call(this),
                            i = this.options.get("selectionCssClass") || "";
                        return -1 !== i.indexOf(":all:") && (i = i.replace(":all:", ""), e.copyNonInternalCssClasses(n[0], this.$element[0])), n.addClass(i), n
                    }, t
                })), t.define("select2/selection/eventRelay", ["jquery"], (function(e) {
                    function t() {}
                    return t.prototype.bind = function(t, n, i) {
                        var a = this,
                            r = ["open", "opening", "close", "closing", "select", "selecting", "unselect", "unselecting", "clear", "clearing"],
                            s = ["opening", "closing", "selecting", "unselecting", "clearing"];
                        t.call(this, n, i), n.on("*", (function(t, n) {
                            if (-1 !== r.indexOf(t)) {
                                n = n || {};
                                var i = e.Event("select2:" + t, {
                                    params: n
                                });
                                a.$element.trigger(i), -1 !== s.indexOf(t) && (n.prevented = i.isDefaultPrevented())
                            }
                        }))
                    }, t
                })), t.define("select2/translation", ["jquery", "require"], (function(e, t) {
                    function n(e) {
                        this.dict = e || {}
                    }
                    return n.prototype.all = function() {
                        return this.dict
                    }, n.prototype.get = function(e) {
                        return this.dict[e]
                    }, n.prototype.extend = function(t) {
                        this.dict = e.extend({}, t.all(), this.dict)
                    }, n._cache = {}, n.loadPath = function(e) {
                        if (!(e in n._cache)) {
                            var i = t(e);
                            n._cache[e] = i
                        }
                        return new n(n._cache[e])
                    }, n
                })), t.define("select2/diacritics", [], (function() {
                    return {
                        "Ⓐ": "A",
                        "Ａ": "A",
                        "À": "A",
                        "Á": "A",
                        "Â": "A",
                        "Ầ": "A",
                        "Ấ": "A",
                        "Ẫ": "A",
                        "Ẩ": "A",
                        "Ã": "A",
                        "Ā": "A",
                        "Ă": "A",
                        "Ằ": "A",
                        "Ắ": "A",
                        "Ẵ": "A",
                        "Ẳ": "A",
                        "Ȧ": "A",
                        "Ǡ": "A",
                        "Ä": "A",
                        "Ǟ": "A",
                        "Ả": "A",
                        "Å": "A",
                        "Ǻ": "A",
                        "Ǎ": "A",
                        "Ȁ": "A",
                        "Ȃ": "A",
                        "Ạ": "A",
                        "Ậ": "A",
                        "Ặ": "A",
                        "Ḁ": "A",
                        "Ą": "A",
                        "Ⱥ": "A",
                        "Ɐ": "A",
                        "Ꜳ": "AA",
                        "Æ": "AE",
                        "Ǽ": "AE",
                        "Ǣ": "AE",
                        "Ꜵ": "AO",
                        "Ꜷ": "AU",
                        "Ꜹ": "AV",
                        "Ꜻ": "AV",
                        "Ꜽ": "AY",
                        "Ⓑ": "B",
                        "Ｂ": "B",
                        "Ḃ": "B",
                        "Ḅ": "B",
                        "Ḇ": "B",
                        "Ƀ": "B",
                        "Ƃ": "B",
                        "Ɓ": "B",
                        "Ⓒ": "C",
                        "Ｃ": "C",
                        "Ć": "C",
                        "Ĉ": "C",
                        "Ċ": "C",
                        "Č": "C",
                        "Ç": "C",
                        "Ḉ": "C",
                        "Ƈ": "C",
                        "Ȼ": "C",
                        "Ꜿ": "C",
                        "Ⓓ": "D",
                        "Ｄ": "D",
                        "Ḋ": "D",
                        "Ď": "D",
                        "Ḍ": "D",
                        "Ḑ": "D",
                        "Ḓ": "D",
                        "Ḏ": "D",
                        "Đ": "D",
                        "Ƌ": "D",
                        "Ɗ": "D",
                        "Ɖ": "D",
                        "Ꝺ": "D",
                        "Ǳ": "DZ",
                        "Ǆ": "DZ",
                        "ǲ": "Dz",
                        "ǅ": "Dz",
                        "Ⓔ": "E",
                        "Ｅ": "E",
                        "È": "E",
                        "É": "E",
                        "Ê": "E",
                        "Ề": "E",
                        "Ế": "E",
                        "Ễ": "E",
                        "Ể": "E",
                        "Ẽ": "E",
                        "Ē": "E",
                        "Ḕ": "E",
                        "Ḗ": "E",
                        "Ĕ": "E",
                        "Ė": "E",
                        "Ë": "E",
                        "Ẻ": "E",
                        "Ě": "E",
                        "Ȅ": "E",
                        "Ȇ": "E",
                        "Ẹ": "E",
                        "Ệ": "E",
                        "Ȩ": "E",
                        "Ḝ": "E",
                        "Ę": "E",
                        "Ḙ": "E",
                        "Ḛ": "E",
                        "Ɛ": "E",
                        "Ǝ": "E",
                        "Ⓕ": "F",
                        "Ｆ": "F",
                        "Ḟ": "F",
                        "Ƒ": "F",
                        "Ꝼ": "F",
                        "Ⓖ": "G",
                        "Ｇ": "G",
                        "Ǵ": "G",
                        "Ĝ": "G",
                        "Ḡ": "G",
                        "Ğ": "G",
                        "Ġ": "G",
                        "Ǧ": "G",
                        "Ģ": "G",
                        "Ǥ": "G",
                        "Ɠ": "G",
                        "Ꞡ": "G",
                        "Ᵹ": "G",
                        "Ꝿ": "G",
                        "Ⓗ": "H",
                        "Ｈ": "H",
                        "Ĥ": "H",
                        "Ḣ": "H",
                        "Ḧ": "H",
                        "Ȟ": "H",
                        "Ḥ": "H",
                        "Ḩ": "H",
                        "Ḫ": "H",
                        "Ħ": "H",
                        "Ⱨ": "H",
                        "Ⱶ": "H",
                        "Ɥ": "H",
                        "Ⓘ": "I",
                        "Ｉ": "I",
                        "Ì": "I",
                        "Í": "I",
                        "Î": "I",
                        "Ĩ": "I",
                        "Ī": "I",
                        "Ĭ": "I",
                        "İ": "I",
                        "Ï": "I",
                        "Ḯ": "I",
                        "Ỉ": "I",
                        "Ǐ": "I",
                        "Ȉ": "I",
                        "Ȋ": "I",
                        "Ị": "I",
                        "Į": "I",
                        "Ḭ": "I",
                        "Ɨ": "I",
                        "Ⓙ": "J",
                        "Ｊ": "J",
                        "Ĵ": "J",
                        "Ɉ": "J",
                        "Ⓚ": "K",
                        "Ｋ": "K",
                        "Ḱ": "K",
                        "Ǩ": "K",
                        "Ḳ": "K",
                        "Ķ": "K",
                        "Ḵ": "K",
                        "Ƙ": "K",
                        "Ⱪ": "K",
                        "Ꝁ": "K",
                        "Ꝃ": "K",
                        "Ꝅ": "K",
                        "Ꞣ": "K",
                        "Ⓛ": "L",
                        "Ｌ": "L",
                        "Ŀ": "L",
                        "Ĺ": "L",
                        "Ľ": "L",
                        "Ḷ": "L",
                        "Ḹ": "L",
                        "Ļ": "L",
                        "Ḽ": "L",
                        "Ḻ": "L",
                        "Ł": "L",
                        "Ƚ": "L",
                        "Ɫ": "L",
                        "Ⱡ": "L",
                        "Ꝉ": "L",
                        "Ꝇ": "L",
                        "Ꞁ": "L",
                        "Ǉ": "LJ",
                        "ǈ": "Lj",
                        "Ⓜ": "M",
                        "Ｍ": "M",
                        "Ḿ": "M",
                        "Ṁ": "M",
                        "Ṃ": "M",
                        "Ɱ": "M",
                        "Ɯ": "M",
                        "Ⓝ": "N",
                        "Ｎ": "N",
                        "Ǹ": "N",
                        "Ń": "N",
                        "Ñ": "N",
                        "Ṅ": "N",
                        "Ň": "N",
                        "Ṇ": "N",
                        "Ņ": "N",
                        "Ṋ": "N",
                        "Ṉ": "N",
                        "Ƞ": "N",
                        "Ɲ": "N",
                        "Ꞑ": "N",
                        "Ꞥ": "N",
                        "Ǌ": "NJ",
                        "ǋ": "Nj",
                        "Ⓞ": "O",
                        "Ｏ": "O",
                        "Ò": "O",
                        "Ó": "O",
                        "Ô": "O",
                        "Ồ": "O",
                        "Ố": "O",
                        "Ỗ": "O",
                        "Ổ": "O",
                        "Õ": "O",
                        "Ṍ": "O",
                        "Ȭ": "O",
                        "Ṏ": "O",
                        "Ō": "O",
                        "Ṑ": "O",
                        "Ṓ": "O",
                        "Ŏ": "O",
                        "Ȯ": "O",
                        "Ȱ": "O",
                        "Ö": "O",
                        "Ȫ": "O",
                        "Ỏ": "O",
                        "Ő": "O",
                        "Ǒ": "O",
                        "Ȍ": "O",
                        "Ȏ": "O",
                        "Ơ": "O",
                        "Ờ": "O",
                        "Ớ": "O",
                        "Ỡ": "O",
                        "Ở": "O",
                        "Ợ": "O",
                        "Ọ": "O",
                        "Ộ": "O",
                        "Ǫ": "O",
                        "Ǭ": "O",
                        "Ø": "O",
                        "Ǿ": "O",
                        "Ɔ": "O",
                        "Ɵ": "O",
                        "Ꝋ": "O",
                        "Ꝍ": "O",
                        "Œ": "OE",
                        "Ƣ": "OI",
                        "Ꝏ": "OO",
                        "Ȣ": "OU",
                        "Ⓟ": "P",
                        "Ｐ": "P",
                        "Ṕ": "P",
                        "Ṗ": "P",
                        "Ƥ": "P",
                        "Ᵽ": "P",
                        "Ꝑ": "P",
                        "Ꝓ": "P",
                        "Ꝕ": "P",
                        "Ⓠ": "Q",
                        "Ｑ": "Q",
                        "Ꝗ": "Q",
                        "Ꝙ": "Q",
                        "Ɋ": "Q",
                        "Ⓡ": "R",
                        "Ｒ": "R",
                        "Ŕ": "R",
                        "Ṙ": "R",
                        "Ř": "R",
                        "Ȑ": "R",
                        "Ȓ": "R",
                        "Ṛ": "R",
                        "Ṝ": "R",
                        "Ŗ": "R",
                        "Ṟ": "R",
                        "Ɍ": "R",
                        "Ɽ": "R",
                        "Ꝛ": "R",
                        "Ꞧ": "R",
                        "Ꞃ": "R",
                        "Ⓢ": "S",
                        "Ｓ": "S",
                        "ẞ": "S",
                        "Ś": "S",
                        "Ṥ": "S",
                        "Ŝ": "S",
                        "Ṡ": "S",
                        "Š": "S",
                        "Ṧ": "S",
                        "Ṣ": "S",
                        "Ṩ": "S",
                        "Ș": "S",
                        "Ş": "S",
                        "Ȿ": "S",
                        "Ꞩ": "S",
                        "Ꞅ": "S",
                        "Ⓣ": "T",
                        "Ｔ": "T",
                        "Ṫ": "T",
                        "Ť": "T",
                        "Ṭ": "T",
                        "Ț": "T",
                        "Ţ": "T",
                        "Ṱ": "T",
                        "Ṯ": "T",
                        "Ŧ": "T",
                        "Ƭ": "T",
                        "Ʈ": "T",
                        "Ⱦ": "T",
                        "Ꞇ": "T",
                        "Ꜩ": "TZ",
                        "Ⓤ": "U",
                        "Ｕ": "U",
                        "Ù": "U",
                        "Ú": "U",
                        "Û": "U",
                        "Ũ": "U",
                        "Ṹ": "U",
                        "Ū": "U",
                        "Ṻ": "U",
                        "Ŭ": "U",
                        "Ü": "U",
                        "Ǜ": "U",
                        "Ǘ": "U",
                        "Ǖ": "U",
                        "Ǚ": "U",
                        "Ủ": "U",
                        "Ů": "U",
                        "Ű": "U",
                        "Ǔ": "U",
                        "Ȕ": "U",
                        "Ȗ": "U",
                        "Ư": "U",
                        "Ừ": "U",
                        "Ứ": "U",
                        "Ữ": "U",
                        "Ử": "U",
                        "Ự": "U",
                        "Ụ": "U",
                        "Ṳ": "U",
                        "Ų": "U",
                        "Ṷ": "U",
                        "Ṵ": "U",
                        "Ʉ": "U",
                        "Ⓥ": "V",
                        "Ｖ": "V",
                        "Ṽ": "V",
                        "Ṿ": "V",
                        "Ʋ": "V",
                        "Ꝟ": "V",
                        "Ʌ": "V",
                        "Ꝡ": "VY",
                        "Ⓦ": "W",
                        "Ｗ": "W",
                        "Ẁ": "W",
                        "Ẃ": "W",
                        "Ŵ": "W",
                        "Ẇ": "W",
                        "Ẅ": "W",
                        "Ẉ": "W",
                        "Ⱳ": "W",
                        "Ⓧ": "X",
                        "Ｘ": "X",
                        "Ẋ": "X",
                        "Ẍ": "X",
                        "Ⓨ": "Y",
                        "Ｙ": "Y",
                        "Ỳ": "Y",
                        "Ý": "Y",
                        "Ŷ": "Y",
                        "Ỹ": "Y",
                        "Ȳ": "Y",
                        "Ẏ": "Y",
                        "Ÿ": "Y",
                        "Ỷ": "Y",
                        "Ỵ": "Y",
                        "Ƴ": "Y",
                        "Ɏ": "Y",
                        "Ỿ": "Y",
                        "Ⓩ": "Z",
                        "Ｚ": "Z",
                        "Ź": "Z",
                        "Ẑ": "Z",
                        "Ż": "Z",
                        "Ž": "Z",
                        "Ẓ": "Z",
                        "Ẕ": "Z",
                        "Ƶ": "Z",
                        "Ȥ": "Z",
                        "Ɀ": "Z",
                        "Ⱬ": "Z",
                        "Ꝣ": "Z",
                        "ⓐ": "a",
                        "ａ": "a",
                        "ẚ": "a",
                        "à": "a",
                        "á": "a",
                        "â": "a",
                        "ầ": "a",
                        "ấ": "a",
                        "ẫ": "a",
                        "ẩ": "a",
                        "ã": "a",
                        "ā": "a",
                        "ă": "a",
                        "ằ": "a",
                        "ắ": "a",
                        "ẵ": "a",
                        "ẳ": "a",
                        "ȧ": "a",
                        "ǡ": "a",
                        "ä": "a",
                        "ǟ": "a",
                        "ả": "a",
                        "å": "a",
                        "ǻ": "a",
                        "ǎ": "a",
                        "ȁ": "a",
                        "ȃ": "a",
                        "ạ": "a",
                        "ậ": "a",
                        "ặ": "a",
                        "ḁ": "a",
                        "ą": "a",
                        "ⱥ": "a",
                        "ɐ": "a",
                        "ꜳ": "aa",
                        "æ": "ae",
                        "ǽ": "ae",
                        "ǣ": "ae",
                        "ꜵ": "ao",
                        "ꜷ": "au",
                        "ꜹ": "av",
                        "ꜻ": "av",
                        "ꜽ": "ay",
                        "ⓑ": "b",
                        "ｂ": "b",
                        "ḃ": "b",
                        "ḅ": "b",
                        "ḇ": "b",
                        "ƀ": "b",
                        "ƃ": "b",
                        "ɓ": "b",
                        "ⓒ": "c",
                        "ｃ": "c",
                        "ć": "c",
                        "ĉ": "c",
                        "ċ": "c",
                        "č": "c",
                        "ç": "c",
                        "ḉ": "c",
                        "ƈ": "c",
                        "ȼ": "c",
                        "ꜿ": "c",
                        "ↄ": "c",
                        "ⓓ": "d",
                        "ｄ": "d",
                        "ḋ": "d",
                        "ď": "d",
                        "ḍ": "d",
                        "ḑ": "d",
                        "ḓ": "d",
                        "ḏ": "d",
                        "đ": "d",
                        "ƌ": "d",
                        "ɖ": "d",
                        "ɗ": "d",
                        "ꝺ": "d",
                        "ǳ": "dz",
                        "ǆ": "dz",
                        "ⓔ": "e",
                        "ｅ": "e",
                        "è": "e",
                        "é": "e",
                        "ê": "e",
                        "ề": "e",
                        "ế": "e",
                        "ễ": "e",
                        "ể": "e",
                        "ẽ": "e",
                        "ē": "e",
                        "ḕ": "e",
                        "ḗ": "e",
                        "ĕ": "e",
                        "ė": "e",
                        "ë": "e",
                        "ẻ": "e",
                        "ě": "e",
                        "ȅ": "e",
                        "ȇ": "e",
                        "ẹ": "e",
                        "ệ": "e",
                        "ȩ": "e",
                        "ḝ": "e",
                        "ę": "e",
                        "ḙ": "e",
                        "ḛ": "e",
                        "ɇ": "e",
                        "ɛ": "e",
                        "ǝ": "e",
                        "ⓕ": "f",
                        "ｆ": "f",
                        "ḟ": "f",
                        "ƒ": "f",
                        "ꝼ": "f",
                        "ⓖ": "g",
                        "ｇ": "g",
                        "ǵ": "g",
                        "ĝ": "g",
                        "ḡ": "g",
                        "ğ": "g",
                        "ġ": "g",
                        "ǧ": "g",
                        "ģ": "g",
                        "ǥ": "g",
                        "ɠ": "g",
                        "ꞡ": "g",
                        "ᵹ": "g",
                        "ꝿ": "g",
                        "ⓗ": "h",
                        "ｈ": "h",
                        "ĥ": "h",
                        "ḣ": "h",
                        "ḧ": "h",
                        "ȟ": "h",
                        "ḥ": "h",
                        "ḩ": "h",
                        "ḫ": "h",
                        "ẖ": "h",
                        "ħ": "h",
                        "ⱨ": "h",
                        "ⱶ": "h",
                        "ɥ": "h",
                        "ƕ": "hv",
                        "ⓘ": "i",
                        "ｉ": "i",
                        "ì": "i",
                        "í": "i",
                        "î": "i",
                        "ĩ": "i",
                        "ī": "i",
                        "ĭ": "i",
                        "ï": "i",
                        "ḯ": "i",
                        "ỉ": "i",
                        "ǐ": "i",
                        "ȉ": "i",
                        "ȋ": "i",
                        "ị": "i",
                        "į": "i",
                        "ḭ": "i",
                        "ɨ": "i",
                        "ı": "i",
                        "ⓙ": "j",
                        "ｊ": "j",
                        "ĵ": "j",
                        "ǰ": "j",
                        "ɉ": "j",
                        "ⓚ": "k",
                        "ｋ": "k",
                        "ḱ": "k",
                        "ǩ": "k",
                        "ḳ": "k",
                        "ķ": "k",
                        "ḵ": "k",
                        "ƙ": "k",
                        "ⱪ": "k",
                        "ꝁ": "k",
                        "ꝃ": "k",
                        "ꝅ": "k",
                        "ꞣ": "k",
                        "ⓛ": "l",
                        "ｌ": "l",
                        "ŀ": "l",
                        "ĺ": "l",
                        "ľ": "l",
                        "ḷ": "l",
                        "ḹ": "l",
                        "ļ": "l",
                        "ḽ": "l",
                        "ḻ": "l",
                        "ſ": "l",
                        "ł": "l",
                        "ƚ": "l",
                        "ɫ": "l",
                        "ⱡ": "l",
                        "ꝉ": "l",
                        "ꞁ": "l",
                        "ꝇ": "l",
                        "ǉ": "lj",
                        "ⓜ": "m",
                        "ｍ": "m",
                        "ḿ": "m",
                        "ṁ": "m",
                        "ṃ": "m",
                        "ɱ": "m",
                        "ɯ": "m",
                        "ⓝ": "n",
                        "ｎ": "n",
                        "ǹ": "n",
                        "ń": "n",
                        "ñ": "n",
                        "ṅ": "n",
                        "ň": "n",
                        "ṇ": "n",
                        "ņ": "n",
                        "ṋ": "n",
                        "ṉ": "n",
                        "ƞ": "n",
                        "ɲ": "n",
                        "ŉ": "n",
                        "ꞑ": "n",
                        "ꞥ": "n",
                        "ǌ": "nj",
                        "ⓞ": "o",
                        "ｏ": "o",
                        "ò": "o",
                        "ó": "o",
                        "ô": "o",
                        "ồ": "o",
                        "ố": "o",
                        "ỗ": "o",
                        "ổ": "o",
                        "õ": "o",
                        "ṍ": "o",
                        "ȭ": "o",
                        "ṏ": "o",
                        "ō": "o",
                        "ṑ": "o",
                        "ṓ": "o",
                        "ŏ": "o",
                        "ȯ": "o",
                        "ȱ": "o",
                        "ö": "o",
                        "ȫ": "o",
                        "ỏ": "o",
                        "ő": "o",
                        "ǒ": "o",
                        "ȍ": "o",
                        "ȏ": "o",
                        "ơ": "o",
                        "ờ": "o",
                        "ớ": "o",
                        "ỡ": "o",
                        "ở": "o",
                        "ợ": "o",
                        "ọ": "o",
                        "ộ": "o",
                        "ǫ": "o",
                        "ǭ": "o",
                        "ø": "o",
                        "ǿ": "o",
                        "ɔ": "o",
                        "ꝋ": "o",
                        "ꝍ": "o",
                        "ɵ": "o",
                        "œ": "oe",
                        "ƣ": "oi",
                        "ȣ": "ou",
                        "ꝏ": "oo",
                        "ⓟ": "p",
                        "ｐ": "p",
                        "ṕ": "p",
                        "ṗ": "p",
                        "ƥ": "p",
                        "ᵽ": "p",
                        "ꝑ": "p",
                        "ꝓ": "p",
                        "ꝕ": "p",
                        "ⓠ": "q",
                        "ｑ": "q",
                        "ɋ": "q",
                        "ꝗ": "q",
                        "ꝙ": "q",
                        "ⓡ": "r",
                        "ｒ": "r",
                        "ŕ": "r",
                        "ṙ": "r",
                        "ř": "r",
                        "ȑ": "r",
                        "ȓ": "r",
                        "ṛ": "r",
                        "ṝ": "r",
                        "ŗ": "r",
                        "ṟ": "r",
                        "ɍ": "r",
                        "ɽ": "r",
                        "ꝛ": "r",
                        "ꞧ": "r",
                        "ꞃ": "r",
                        "ⓢ": "s",
                        "ｓ": "s",
                        "ß": "s",
                        "ś": "s",
                        "ṥ": "s",
                        "ŝ": "s",
                        "ṡ": "s",
                        "š": "s",
                        "ṧ": "s",
                        "ṣ": "s",
                        "ṩ": "s",
                        "ș": "s",
                        "ş": "s",
                        "ȿ": "s",
                        "ꞩ": "s",
                        "ꞅ": "s",
                        "ẛ": "s",
                        "ⓣ": "t",
                        "ｔ": "t",
                        "ṫ": "t",
                        "ẗ": "t",
                        "ť": "t",
                        "ṭ": "t",
                        "ț": "t",
                        "ţ": "t",
                        "ṱ": "t",
                        "ṯ": "t",
                        "ŧ": "t",
                        "ƭ": "t",
                        "ʈ": "t",
                        "ⱦ": "t",
                        "ꞇ": "t",
                        "ꜩ": "tz",
                        "ⓤ": "u",
                        "ｕ": "u",
                        "ù": "u",
                        "ú": "u",
                        "û": "u",
                        "ũ": "u",
                        "ṹ": "u",
                        "ū": "u",
                        "ṻ": "u",
                        "ŭ": "u",
                        "ü": "u",
                        "ǜ": "u",
                        "ǘ": "u",
                        "ǖ": "u",
                        "ǚ": "u",
                        "ủ": "u",
                        "ů": "u",
                        "ű": "u",
                        "ǔ": "u",
                        "ȕ": "u",
                        "ȗ": "u",
                        "ư": "u",
                        "ừ": "u",
                        "ứ": "u",
                        "ữ": "u",
                        "ử": "u",
                        "ự": "u",
                        "ụ": "u",
                        "ṳ": "u",
                        "ų": "u",
                        "ṷ": "u",
                        "ṵ": "u",
                        "ʉ": "u",
                        "ⓥ": "v",
                        "ｖ": "v",
                        "ṽ": "v",
                        "ṿ": "v",
                        "ʋ": "v",
                        "ꝟ": "v",
                        "ʌ": "v",
                        "ꝡ": "vy",
                        "ⓦ": "w",
                        "ｗ": "w",
                        "ẁ": "w",
                        "ẃ": "w",
                        "ŵ": "w",
                        "ẇ": "w",
                        "ẅ": "w",
                        "ẘ": "w",
                        "ẉ": "w",
                        "ⱳ": "w",
                        "ⓧ": "x",
                        "ｘ": "x",
                        "ẋ": "x",
                        "ẍ": "x",
                        "ⓨ": "y",
                        "ｙ": "y",
                        "ỳ": "y",
                        "ý": "y",
                        "ŷ": "y",
                        "ỹ": "y",
                        "ȳ": "y",
                        "ẏ": "y",
                        "ÿ": "y",
                        "ỷ": "y",
                        "ẙ": "y",
                        "ỵ": "y",
                        "ƴ": "y",
                        "ɏ": "y",
                        "ỿ": "y",
                        "ⓩ": "z",
                        "ｚ": "z",
                        "ź": "z",
                        "ẑ": "z",
                        "ż": "z",
                        "ž": "z",
                        "ẓ": "z",
                        "ẕ": "z",
                        "ƶ": "z",
                        "ȥ": "z",
                        "ɀ": "z",
                        "ⱬ": "z",
                        "ꝣ": "z",
                        "Ά": "Α",
                        "Έ": "Ε",
                        "Ή": "Η",
                        "Ί": "Ι",
                        "Ϊ": "Ι",
                        "Ό": "Ο",
                        "Ύ": "Υ",
                        "Ϋ": "Υ",
                        "Ώ": "Ω",
                        "ά": "α",
                        "έ": "ε",
                        "ή": "η",
                        "ί": "ι",
                        "ϊ": "ι",
                        "ΐ": "ι",
                        "ό": "ο",
                        "ύ": "υ",
                        "ϋ": "υ",
                        "ΰ": "υ",
                        "ώ": "ω",
                        "ς": "σ",
                        "’": "'"
                    }
                })), t.define("select2/data/base", ["../utils"], (function(e) {
                    function t(e, n) {
                        t.__super__.constructor.call(this)
                    }
                    return e.Extend(t, e.Observable), t.prototype.current = function(e) {
                        throw new Error("The `current` method must be defined in child classes.")
                    }, t.prototype.query = function(e, t) {
                        throw new Error("The `query` method must be defined in child classes.")
                    }, t.prototype.bind = function(e, t) {}, t.prototype.destroy = function() {}, t.prototype.generateResultId = function(t, n) {
                        var i = t.id + "-result-";
                        return i += e.generateChars(4), null != n.id ? i += "-" + n.id.toString() : i += "-" + e.generateChars(4), i
                    }, t
                })), t.define("select2/data/select", ["./base", "../utils", "jquery"], (function(e, t, n) {
                    function i(e, t) {
                        this.$element = e, this.options = t, i.__super__.constructor.call(this)
                    }
                    return t.Extend(i, e), i.prototype.current = function(e) {
                        var t = this;
                        e(Array.prototype.map.call(this.$element[0].querySelectorAll(":checked"), (function(e) {
                            return t.item(n(e))
                        })))
                    }, i.prototype.select = function(e) {
                        var t = this;
                        if (e.selected = !0, null != e.element && "option" === e.element.tagName.toLowerCase()) return e.element.selected = !0, void this.$element.trigger("input").trigger("change");
                        if (this.$element.prop("multiple")) this.current((function(n) {
                            var i = [];
                            (e = [e]).push.apply(e, n);
                            for (var a = 0; a < e.length; a++) {
                                var r = e[a].id; - 1 === i.indexOf(r) && i.push(r)
                            }
                            t.$element.val(i), t.$element.trigger("input").trigger("change")
                        }));
                        else {
                            var n = e.id;
                            this.$element.val(n), this.$element.trigger("input").trigger("change")
                        }
                    }, i.prototype.unselect = function(e) {
                        var t = this;
                        if (this.$element.prop("multiple")) {
                            if (e.selected = !1, null != e.element && "option" === e.element.tagName.toLowerCase()) return e.element.selected = !1, void this.$element.trigger("input").trigger("change");
                            this.current((function(n) {
                                for (var i = [], a = 0; a < n.length; a++) {
                                    var r = n[a].id;
                                    r !== e.id && -1 === i.indexOf(r) && i.push(r)
                                }
                                t.$element.val(i), t.$element.trigger("input").trigger("change")
                            }))
                        }
                    }, i.prototype.bind = function(e, t) {
                        var n = this;
                        this.container = e, e.on("select", (function(e) {
                            n.select(e.data)
                        })), e.on("unselect", (function(e) {
                            n.unselect(e.data)
                        }))
                    }, i.prototype.destroy = function() {
                        this.$element.find("*").each((function() {
                            t.RemoveData(this)
                        }))
                    }, i.prototype.query = function(e, t) {
                        var i = [],
                            a = this;
                        this.$element.children().each((function() {
                            if ("option" === this.tagName.toLowerCase() || "optgroup" === this.tagName.toLowerCase()) {
                                var t = n(this),
                                    r = a.item(t),
                                    s = a.matches(e, r);
                                null !== s && i.push(s)
                            }
                        })), t({
                            results: i
                        })
                    }, i.prototype.addOptions = function(e) {
                        this.$element.append(e)
                    }, i.prototype.option = function(e) {
                        var i;
                        e.children ? (i = document.createElement("optgroup")).label = e.text : void 0 !== (i = document.createElement("option")).textContent ? i.textContent = e.text : i.innerText = e.text, void 0 !== e.id && (i.value = e.id), e.disabled && (i.disabled = !0), e.selected && (i.selected = !0), e.title && (i.title = e.title);
                        var a = this._normalizeItem(e);
                        return a.element = i, t.StoreData(i, "data", a), n(i)
                    }, i.prototype.item = function(e) {
                        var i = {};
                        if (null != (i = t.GetData(e[0], "data"))) return i;
                        var a = e[0];
                        if ("option" === a.tagName.toLowerCase()) i = {
                            id: e.val(),
                            text: e.text(),
                            disabled: e.prop("disabled"),
                            selected: e.prop("selected"),
                            title: e.prop("title")
                        };
                        else if ("optgroup" === a.tagName.toLowerCase()) {
                            i = {
                                text: e.prop("label"),
                                children: [],
                                title: e.prop("title")
                            };
                            for (var r = e.children("option"), s = [], o = 0; o < r.length; o++) {
                                var l = n(r[o]),
                                    c = this.item(l);
                                s.push(c)
                            }
                            i.children = s
                        }
                        return (i = this._normalizeItem(i)).element = e[0], t.StoreData(e[0], "data", i), i
                    }, i.prototype._normalizeItem = function(e) {
                        e !== Object(e) && (e = {
                            id: e,
                            text: e
                        });
                        return null != (e = n.extend({}, {
                            text: ""
                        }, e)).id && (e.id = e.id.toString()), null != e.text && (e.text = e.text.toString()), null == e._resultId && e.id && null != this.container && (e._resultId = this.generateResultId(this.container, e)), n.extend({}, {
                            selected: !1,
                            disabled: !1
                        }, e)
                    }, i.prototype.matches = function(e, t) {
                        return this.options.get("matcher")(e, t)
                    }, i
                })), t.define("select2/data/array", ["./select", "../utils", "jquery"], (function(e, t, n) {
                    function i(e, t) {
                        this._dataToConvert = t.get("data") || [], i.__super__.constructor.call(this, e, t)
                    }
                    return t.Extend(i, e), i.prototype.bind = function(e, t) {
                        i.__super__.bind.call(this, e, t), this.addOptions(this.convertToOptions(this._dataToConvert))
                    }, i.prototype.select = function(e) {
                        var t = this.$element.find("option").filter((function(t, n) {
                            return n.value == e.id.toString()
                        }));
                        0 === t.length && (t = this.option(e), this.addOptions(t)), i.__super__.select.call(this, e)
                    }, i.prototype.convertToOptions = function(e) {
                        var t = this,
                            i = this.$element.find("option"),
                            a = i.map((function() {
                                return t.item(n(this)).id
                            })).get(),
                            r = [];

                        function s(e) {
                            return function() {
                                return n(this).val() == e.id
                            }
                        }
                        for (var o = 0; o < e.length; o++) {
                            var l = this._normalizeItem(e[o]);
                            if (a.indexOf(l.id) >= 0) {
                                var c = i.filter(s(l)),
                                    u = this.item(c),
                                    d = n.extend(!0, {}, l, u),
                                    h = this.option(d);
                                c.replaceWith(h)
                            } else {
                                var f = this.option(l);
                                if (l.children) {
                                    var p = this.convertToOptions(l.children);
                                    f.append(p)
                                }
                                r.push(f)
                            }
                        }
                        return r
                    }, i
                })), t.define("select2/data/ajax", ["./array", "../utils", "jquery"], (function(e, t, n) {
                    function i(e, t) {
                        this.ajaxOptions = this._applyDefaults(t.get("ajax")), null != this.ajaxOptions.processResults && (this.processResults = this.ajaxOptions.processResults), i.__super__.constructor.call(this, e, t)
                    }
                    return t.Extend(i, e), i.prototype._applyDefaults = function(e) {
                        var t = {
                            data: function(e) {
                                return n.extend({}, e, {
                                    q: e.term
                                })
                            },
                            transport: function(e, t, i) {
                                var a = n.ajax(e);
                                return a.then(t), a.fail(i), a
                            }
                        };
                        return n.extend({}, t, e, !0)
                    }, i.prototype.processResults = function(e) {
                        return e
                    }, i.prototype.query = function(e, t) {
                        var i = this;
                        null != this._request && ("function" == typeof this._request.abort && this._request.abort(), this._request = null);
                        var a = n.extend({
                            type: "GET"
                        }, this.ajaxOptions);

                        function r() {
                            var n = a.transport(a, (function(n) {
                                var a = i.processResults(n, e);
                                i.options.get("debug") && window.console && console.error && (a && a.results && Array.isArray(a.results) || console.error("Select2: The AJAX results did not return an array in the `results` key of the response.")), t(a)
                            }), (function() {
                                (!("status" in n) || 0 !== n.status && "0" !== n.status) && i.trigger("results:message", {
                                    message: "errorLoading"
                                })
                            }));
                            i._request = n
                        }
                        "function" == typeof a.url && (a.url = a.url.call(this.$element, e)), "function" == typeof a.data && (a.data = a.data.call(this.$element, e)), this.ajaxOptions.delay && null != e.term ? (this._queryTimeout && window.clearTimeout(this._queryTimeout), this._queryTimeout = window.setTimeout(r, this.ajaxOptions.delay)) : r()
                    }, i
                })), t.define("select2/data/tags", ["jquery"], (function(e) {
                    function t(e, t, n) {
                        var i = n.get("tags"),
                            a = n.get("createTag");
                        void 0 !== a && (this.createTag = a);
                        var r = n.get("insertTag");
                        if (void 0 !== r && (this.insertTag = r), e.call(this, t, n), Array.isArray(i))
                            for (var s = 0; s < i.length; s++) {
                                var o = i[s],
                                    l = this._normalizeItem(o),
                                    c = this.option(l);
                                this.$element.append(c)
                            }
                    }
                    return t.prototype.query = function(e, t, n) {
                        var i = this;
                        this._removeOldTags(), null != t.term && null == t.page ? e.call(this, t, (function e(a, r) {
                            for (var s = a.results, o = 0; o < s.length; o++) {
                                var l = s[o],
                                    c = null != l.children && !e({
                                        results: l.children
                                    }, !0);
                                if ((l.text || "").toUpperCase() === (t.term || "").toUpperCase() || c) return !r && (a.data = s, void n(a))
                            }
                            if (r) return !0;
                            var u = i.createTag(t);
                            if (null != u) {
                                var d = i.option(u);
                                d.attr("data-select2-tag", "true"), i.addOptions([d]), i.insertTag(s, u)
                            }
                            a.results = s, n(a)
                        })) : e.call(this, t, n)
                    }, t.prototype.createTag = function(e, t) {
                        if (null == t.term) return null;
                        var n = t.term.trim();
                        return "" === n ? null : {
                            id: n,
                            text: n
                        }
                    }, t.prototype.insertTag = function(e, t, n) {
                        t.unshift(n)
                    }, t.prototype._removeOldTags = function(t) {
                        this.$element.find("option[data-select2-tag]").each((function() {
                            this.selected || e(this).remove()
                        }))
                    }, t
                })), t.define("select2/data/tokenizer", ["jquery"], (function(e) {
                    function t(e, t, n) {
                        var i = n.get("tokenizer");
                        void 0 !== i && (this.tokenizer = i), e.call(this, t, n)
                    }
                    return t.prototype.bind = function(e, t, n) {
                        e.call(this, t, n), this.$search = t.dropdown.$search || t.selection.$search || n.find(".select2-search__field")
                    }, t.prototype.query = function(t, n, i) {
                        var a = this;
                        n.term = n.term || "";
                        var r = this.tokenizer(n, this.options, (function(t) {
                            var n = a._normalizeItem(t);
                            if (!a.$element.find("option").filter((function() {
                                    return e(this).val() === n.id
                                })).length) {
                                var i = a.option(n);
                                i.attr("data-select2-tag", !0), a._removeOldTags(), a.addOptions([i])
                            }! function(e) {
                                a.trigger("select", {
                                    data: e
                                })
                            }(n)
                        }));
                        r.term !== n.term && (this.$search.length && (this.$search.val(r.term), this.$search.trigger("focus")), n.term = r.term), t.call(this, n, i)
                    }, t.prototype.tokenizer = function(t, n, i, a) {
                        for (var r = i.get("tokenSeparators") || [], s = n.term, o = 0, l = this.createTag || function(e) {
                                return {
                                    id: e.term,
                                    text: e.term
                                }
                            }; o < s.length;) {
                            var c = s[o];
                            if (-1 !== r.indexOf(c)) {
                                var u = s.substr(0, o),
                                    d = l(e.extend({}, n, {
                                        term: u
                                    }));
                                null != d ? (a(d), s = s.substr(o + 1) || "", o = 0) : o++
                            } else o++
                        }
                        return {
                            term: s
                        }
                    }, t
                })), t.define("select2/data/minimumInputLength", [], (function() {
                    function e(e, t, n) {
                        this.minimumInputLength = n.get("minimumInputLength"), e.call(this, t, n)
                    }
                    return e.prototype.query = function(e, t, n) {
                        t.term = t.term || "", t.term.length < this.minimumInputLength ? this.trigger("results:message", {
                            message: "inputTooShort",
                            args: {
                                minimum: this.minimumInputLength,
                                input: t.term,
                                params: t
                            }
                        }) : e.call(this, t, n)
                    }, e
                })), t.define("select2/data/maximumInputLength", [], (function() {
                    function e(e, t, n) {
                        this.maximumInputLength = n.get("maximumInputLength"), e.call(this, t, n)
                    }
                    return e.prototype.query = function(e, t, n) {
                        t.term = t.term || "", this.maximumInputLength > 0 && t.term.length > this.maximumInputLength ? this.trigger("results:message", {
                            message: "inputTooLong",
                            args: {
                                maximum: this.maximumInputLength,
                                input: t.term,
                                params: t
                            }
                        }) : e.call(this, t, n)
                    }, e
                })), t.define("select2/data/maximumSelectionLength", [], (function() {
                    function e(e, t, n) {
                        this.maximumSelectionLength = n.get("maximumSelectionLength"), e.call(this, t, n)
                    }
                    return e.prototype.bind = function(e, t, n) {
                        var i = this;
                        e.call(this, t, n), t.on("select", (function() {
                            i._checkIfMaximumSelected()
                        }))
                    }, e.prototype.query = function(e, t, n) {
                        var i = this;
                        this._checkIfMaximumSelected((function() {
                            e.call(i, t, n)
                        }))
                    }, e.prototype._checkIfMaximumSelected = function(e, t) {
                        var n = this;
                        this.current((function(e) {
                            var i = null != e ? e.length : 0;
                            n.maximumSelectionLength > 0 && i >= n.maximumSelectionLength ? n.trigger("results:message", {
                                message: "maximumSelected",
                                args: {
                                    maximum: n.maximumSelectionLength
                                }
                            }) : t && t()
                        }))
                    }, e
                })), t.define("select2/dropdown", ["jquery", "./utils"], (function(e, t) {
                    function n(e, t) {
                        this.$element = e, this.options = t, n.__super__.constructor.call(this)
                    }
                    return t.Extend(n, t.Observable), n.prototype.render = function() {
                        var t = e('<span class="select2-dropdown"><span class="select2-results"></span></span>');
                        return t.attr("dir", this.options.get("dir")), this.$dropdown = t, t
                    }, n.prototype.bind = function() {}, n.prototype.position = function(e, t) {}, n.prototype.destroy = function() {
                        this.$dropdown.remove()
                    }, n
                })), t.define("select2/dropdown/search", ["jquery"], (function(e) {
                    function t() {}
                    return t.prototype.render = function(t) {
                        var n = t.call(this),
                            i = this.options.get("translations").get("search"),
                            a = e('<span class="select2-search select2-search--dropdown"><input class="select2-search__field" type="search" tabindex="-1" autocorrect="off" autocapitalize="none" spellcheck="false" role="searchbox" aria-autocomplete="list" /></span>');
                        return this.$searchContainer = a, this.$search = a.find("input"), this.$search.prop("autocomplete", this.options.get("autocomplete")), this.$search.attr("aria-label", i()), n.prepend(a), n
                    }, t.prototype.bind = function(t, n, i) {
                        var a = this,
                            r = n.id + "-results";
                        t.call(this, n, i), this.$search.on("keydown", (function(e) {
                            a.trigger("keypress", e), a._keyUpPrevented = e.isDefaultPrevented()
                        })), this.$search.on("input", (function(t) {
                            e(this).off("keyup")
                        })), this.$search.on("keyup input", (function(e) {
                            a.handleSearch(e)
                        })), n.on("open", (function() {
                            a.$search.attr("tabindex", 0), a.$search.attr("aria-controls", r), a.$search.trigger("focus"), window.setTimeout((function() {
                                a.$search.trigger("focus")
                            }), 0)
                        })), n.on("close", (function() {
                            a.$search.attr("tabindex", -1), a.$search.removeAttr("aria-controls"), a.$search.removeAttr("aria-activedescendant"), a.$search.val(""), a.$search.trigger("blur")
                        })), n.on("focus", (function() {
                            n.isOpen() || a.$search.trigger("focus")
                        })), n.on("results:all", (function(e) {
                            null != e.query.term && "" !== e.query.term || (a.showSearch(e) ? a.$searchContainer[0].classList.remove("select2-search--hide") : a.$searchContainer[0].classList.add("select2-search--hide"))
                        })), n.on("results:focus", (function(e) {
                            e.data._resultId ? a.$search.attr("aria-activedescendant", e.data._resultId) : a.$search.removeAttr("aria-activedescendant")
                        }))
                    }, t.prototype.handleSearch = function(e) {
                        if (!this._keyUpPrevented) {
                            var t = this.$search.val();
                            this.trigger("query", {
                                term: t
                            })
                        }
                        this._keyUpPrevented = !1
                    }, t.prototype.showSearch = function(e, t) {
                        return !0
                    }, t
                })), t.define("select2/dropdown/hidePlaceholder", [], (function() {
                    function e(e, t, n, i) {
                        this.placeholder = this.normalizePlaceholder(n.get("placeholder")), e.call(this, t, n, i)
                    }
                    return e.prototype.append = function(e, t) {
                        t.results = this.removePlaceholder(t.results), e.call(this, t)
                    }, e.prototype.normalizePlaceholder = function(e, t) {
                        return "string" == typeof t && (t = {
                            id: "",
                            text: t
                        }), t
                    }, e.prototype.removePlaceholder = function(e, t) {
                        for (var n = t.slice(0), i = t.length - 1; i >= 0; i--) {
                            var a = t[i];
                            this.placeholder.id === a.id && n.splice(i, 1)
                        }
                        return n
                    }, e
                })), t.define("select2/dropdown/infiniteScroll", ["jquery"], (function(e) {
                    function t(e, t, n, i) {
                        this.lastParams = {}, e.call(this, t, n, i), this.$loadingMore = this.createLoadingMore(), this.loading = !1
                    }
                    return t.prototype.append = function(e, t) {
                        this.$loadingMore.remove(), this.loading = !1, e.call(this, t), this.showLoadingMore(t) && (this.$results.append(this.$loadingMore), this.loadMoreIfNeeded())
                    }, t.prototype.bind = function(e, t, n) {
                        var i = this;
                        e.call(this, t, n), t.on("query", (function(e) {
                            i.lastParams = e, i.loading = !0
                        })), t.on("query:append", (function(e) {
                            i.lastParams = e, i.loading = !0
                        })), this.$results.on("scroll", this.loadMoreIfNeeded.bind(this))
                    }, t.prototype.loadMoreIfNeeded = function() {
                        var t = e.contains(document.documentElement, this.$loadingMore[0]);
                        !this.loading && t && (this.$results.offset().top + this.$results.outerHeight(!1) + 50 >= this.$loadingMore.offset().top + this.$loadingMore.outerHeight(!1) && this.loadMore())
                    }, t.prototype.loadMore = function() {
                        this.loading = !0;
                        var t = e.extend({}, {
                            page: 1
                        }, this.lastParams);
                        t.page++, this.trigger("query:append", t)
                    }, t.prototype.showLoadingMore = function(e, t) {
                        return t.pagination && t.pagination.more
                    }, t.prototype.createLoadingMore = function() {
                        var t = e('<li class="select2-results__option select2-results__option--load-more"role="option" aria-disabled="true"></li>'),
                            n = this.options.get("translations").get("loadingMore");
                        return t.html(n(this.lastParams)), t
                    }, t
                })), t.define("select2/dropdown/attachBody", ["jquery", "../utils"], (function(e, t) {
                    function n(t, n, i) {
                        this.$dropdownParent = e(i.get("dropdownParent") || document.body), t.call(this, n, i)
                    }
                    return n.prototype.bind = function(e, t, n) {
                        var i = this;
                        e.call(this, t, n), t.on("open", (function() {
                            i._showDropdown(), i._attachPositioningHandler(t), i._bindContainerResultHandlers(t)
                        })), t.on("close", (function() {
                            i._hideDropdown(), i._detachPositioningHandler(t)
                        })), this.$dropdownContainer.on("mousedown", (function(e) {
                            e.stopPropagation()
                        }))
                    }, n.prototype.destroy = function(e) {
                        e.call(this), this.$dropdownContainer.remove()
                    }, n.prototype.position = function(e, t, n) {
                        t.attr("class", n.attr("class")), t[0].classList.remove("select2"), t[0].classList.add("select2-container--open"), t.css({
                            position: "absolute",
                            top: -999999
                        }), this.$container = n
                    }, n.prototype.render = function(t) {
                        var n = e("<span></span>"),
                            i = t.call(this);
                        return n.append(i), this.$dropdownContainer = n, n
                    }, n.prototype._hideDropdown = function(e) {
                        this.$dropdownContainer.detach()
                    }, n.prototype._bindContainerResultHandlers = function(e, t) {
                        if (!this._containerResultsHandlersBound) {
                            var n = this;
                            t.on("results:all", (function() {
                                n._positionDropdown(), n._resizeDropdown()
                            })), t.on("results:append", (function() {
                                n._positionDropdown(), n._resizeDropdown()
                            })), t.on("results:message", (function() {
                                n._positionDropdown(), n._resizeDropdown()
                            })), t.on("select", (function() {
                                n._positionDropdown(), n._resizeDropdown()
                            })), t.on("unselect", (function() {
                                n._positionDropdown(), n._resizeDropdown()
                            })), this._containerResultsHandlersBound = !0
                        }
                    }, n.prototype._attachPositioningHandler = function(n, i) {
                        var a = this,
                            r = "scroll.select2." + i.id,
                            s = "resize.select2." + i.id,
                            o = "orientationchange.select2." + i.id,
                            l = this.$container.parents().filter(t.hasScroll);
                        l.each((function() {
                            t.StoreData(this, "select2-scroll-position", {
                                x: e(this).scrollLeft(),
                                y: e(this).scrollTop()
                            })
                        })), l.on(r, (function(n) {
                            var i = t.GetData(this, "select2-scroll-position");
                            e(this).scrollTop(i.y)
                        })), e(window).on(r + " " + s + " " + o, (function(e) {
                            a._positionDropdown(), a._resizeDropdown()
                        }))
                    }, n.prototype._detachPositioningHandler = function(n, i) {
                        var a = "scroll.select2." + i.id,
                            r = "resize.select2." + i.id,
                            s = "orientationchange.select2." + i.id;
                        this.$container.parents().filter(t.hasScroll).off(a), e(window).off(a + " " + r + " " + s)
                    }, n.prototype._positionDropdown = function() {
                        var t = e(window),
                            n = this.$dropdown[0].classList.contains("select2-dropdown--above"),
                            i = this.$dropdown[0].classList.contains("select2-dropdown--below"),
                            a = null,
                            r = this.$container.offset();
                        r.bottom = r.top + this.$container.outerHeight(!1);
                        var s = {
                            height: this.$container.outerHeight(!1)
                        };
                        s.top = r.top, s.bottom = r.top + s.height;
                        var o = this.$dropdown.outerHeight(!1),
                            l = t.scrollTop(),
                            c = t.scrollTop() + t.height(),
                            u = l < r.top - o,
                            d = c > r.bottom + o,
                            h = {
                                left: r.left,
                                top: s.bottom
                            },
                            f = this.$dropdownParent;
                        "static" === f.css("position") && (f = f.offsetParent());
                        var p = {
                            top: 0,
                            left: 0
                        };
                        (e.contains(document.body, f[0]) || f[0].isConnected) && (p = f.offset()), h.top -= p.top, h.left -= p.left, n || i || (a = "below"), d || !u || n ? !u && d && n && (a = "below") : a = "above", ("above" == a || n && "below" !== a) && (h.top = s.top - p.top - o), null != a && (this.$dropdown[0].classList.remove("select2-dropdown--below"), this.$dropdown[0].classList.remove("select2-dropdown--above"), this.$dropdown[0].classList.add("select2-dropdown--" + a), this.$container[0].classList.remove("select2-container--below"), this.$container[0].classList.remove("select2-container--above"), this.$container[0].classList.add("select2-container--" + a)), this.$dropdownContainer.css(h)
                    }, n.prototype._resizeDropdown = function() {
                        var e = {
                            width: this.$container.outerWidth(!1) + "px"
                        };
                        this.options.get("dropdownAutoWidth") && (e.minWidth = e.width, e.position = "relative", e.width = "auto"), this.$dropdown.css(e)
                    }, n.prototype._showDropdown = function(e) {
                        this.$dropdownContainer.appendTo(this.$dropdownParent), this._positionDropdown(), this._resizeDropdown()
                    }, n
                })), t.define("select2/dropdown/minimumResultsForSearch", [], (function() {
                    function e(t) {
                        for (var n = 0, i = 0; i < t.length; i++) {
                            var a = t[i];
                            a.children ? n += e(a.children) : n++
                        }
                        return n
                    }

                    function t(e, t, n, i) {
                        this.minimumResultsForSearch = n.get("minimumResultsForSearch"), this.minimumResultsForSearch < 0 && (this.minimumResultsForSearch = 1 / 0), e.call(this, t, n, i)
                    }
                    return t.prototype.showSearch = function(t, n) {
                        return !(e(n.data.results) < this.minimumResultsForSearch) && t.call(this, n)
                    }, t
                })), t.define("select2/dropdown/selectOnClose", ["../utils"], (function(e) {
                    function t() {}
                    return t.prototype.bind = function(e, t, n) {
                        var i = this;
                        e.call(this, t, n), t.on("close", (function(e) {
                            i._handleSelectOnClose(e)
                        }))
                    }, t.prototype._handleSelectOnClose = function(t, n) {
                        if (n && null != n.originalSelect2Event) {
                            var i = n.originalSelect2Event;
                            if ("select" === i._type || "unselect" === i._type) return
                        }
                        var a = this.getHighlightedResults();
                        if (!(a.length < 1)) {
                            var r = e.GetData(a[0], "data");
                            null != r.element && r.element.selected || null == r.element && r.selected || this.trigger("select", {
                                data: r
                            })
                        }
                    }, t
                })), t.define("select2/dropdown/closeOnSelect", [], (function() {
                    function e() {}
                    return e.prototype.bind = function(e, t, n) {
                        var i = this;
                        e.call(this, t, n), t.on("select", (function(e) {
                            i._selectTriggered(e)
                        })), t.on("unselect", (function(e) {
                            i._selectTriggered(e)
                        }))
                    }, e.prototype._selectTriggered = function(e, t) {
                        var n = t.originalEvent;
                        n && (n.ctrlKey || n.metaKey) || this.trigger("close", {
                            originalEvent: n,
                            originalSelect2Event: t
                        })
                    }, e
                })), t.define("select2/dropdown/dropdownCss", ["../utils"], (function(e) {
                    function t() {}
                    return t.prototype.render = function(t) {
                        var n = t.call(this),
                            i = this.options.get("dropdownCssClass") || "";
                        return -1 !== i.indexOf(":all:") && (i = i.replace(":all:", ""), e.copyNonInternalCssClasses(n[0], this.$element[0])), n.addClass(i), n
                    }, t
                })), t.define("select2/dropdown/tagsSearchHighlight", ["../utils"], (function(e) {
                    function t() {}
                    return t.prototype.highlightFirstItem = function(t) {
                        var n = this.$results.find(".select2-results__option--selectable:not(.select2-results__option--selected)");
                        if (n.length > 0) {
                            var i = n.first(),
                                a = e.GetData(i[0], "data").element;
                            if (a && a.getAttribute && "true" === a.getAttribute("data-select2-tag")) return void i.trigger("mouseenter")
                        }
                        t.call(this)
                    }, t
                })), t.define("select2/i18n/en", [], (function() {
                    return {
                        errorLoading: function() {
                            return "The results could not be loaded."
                        },
                        inputTooLong: function(e) {
                            var t = e.input.length - e.maximum,
                                n = "Please delete " + t + " character";
                            return 1 != t && (n += "s"), n
                        },
                        inputTooShort: function(e) {
                            return "Please enter " + (e.minimum - e.input.length) + " or more characters"
                        },
                        loadingMore: function() {
                            return "Loading more results…"
                        },
                        maximumSelected: function(e) {
                            var t = "You can only select " + e.maximum + " item";
                            return 1 != e.maximum && (t += "s"), t
                        },
                        noResults: function() {
                            return "No results found"
                        },
                        searching: function() {
                            return "Searching…"
                        },
                        removeAllItems: function() {
                            return "Remove all items"
                        },
                        removeItem: function() {
                            return "Remove item"
                        },
                        search: function() {
                            return "Search"
                        }
                    }
                })), t.define("select2/defaults", ["jquery", "./results", "./selection/single", "./selection/multiple", "./selection/placeholder", "./selection/allowClear", "./selection/search", "./selection/selectionCss", "./selection/eventRelay", "./utils", "./translation", "./diacritics", "./data/select", "./data/array", "./data/ajax", "./data/tags", "./data/tokenizer", "./data/minimumInputLength", "./data/maximumInputLength", "./data/maximumSelectionLength", "./dropdown", "./dropdown/search", "./dropdown/hidePlaceholder", "./dropdown/infiniteScroll", "./dropdown/attachBody", "./dropdown/minimumResultsForSearch", "./dropdown/selectOnClose", "./dropdown/closeOnSelect", "./dropdown/dropdownCss", "./dropdown/tagsSearchHighlight", "./i18n/en"], (function(e, t, n, i, a, r, s, o, l, c, u, d, h, f, p, g, m, v, y, b, x, _, w, k, M, L, S, A, T, C, D) {
                    function E() {
                        this.reset()
                    }
                    return E.prototype.apply = function(u) {
                        if (null == (u = e.extend(!0, {}, this.defaults, u)).dataAdapter && (null != u.ajax ? u.dataAdapter = p : null != u.data ? u.dataAdapter = f : u.dataAdapter = h, u.minimumInputLength > 0 && (u.dataAdapter = c.Decorate(u.dataAdapter, v)), u.maximumInputLength > 0 && (u.dataAdapter = c.Decorate(u.dataAdapter, y)), u.maximumSelectionLength > 0 && (u.dataAdapter = c.Decorate(u.dataAdapter, b)), u.tags && (u.dataAdapter = c.Decorate(u.dataAdapter, g)), null == u.tokenSeparators && null == u.tokenizer || (u.dataAdapter = c.Decorate(u.dataAdapter, m))), null == u.resultsAdapter && (u.resultsAdapter = t, null != u.ajax && (u.resultsAdapter = c.Decorate(u.resultsAdapter, k)), null != u.placeholder && (u.resultsAdapter = c.Decorate(u.resultsAdapter, w)), u.selectOnClose && (u.resultsAdapter = c.Decorate(u.resultsAdapter, S)), u.tags && (u.resultsAdapter = c.Decorate(u.resultsAdapter, C))), null == u.dropdownAdapter) {
                            if (u.multiple) u.dropdownAdapter = x;
                            else {
                                var d = c.Decorate(x, _);
                                u.dropdownAdapter = d
                            }
                            0 !== u.minimumResultsForSearch && (u.dropdownAdapter = c.Decorate(u.dropdownAdapter, L)), u.closeOnSelect && (u.dropdownAdapter = c.Decorate(u.dropdownAdapter, A)), null != u.dropdownCssClass && (u.dropdownAdapter = c.Decorate(u.dropdownAdapter, T)), u.dropdownAdapter = c.Decorate(u.dropdownAdapter, M)
                        }
                        null == u.selectionAdapter && (u.multiple ? u.selectionAdapter = i : u.selectionAdapter = n, null != u.placeholder && (u.selectionAdapter = c.Decorate(u.selectionAdapter, a)), u.allowClear && (u.selectionAdapter = c.Decorate(u.selectionAdapter, r)), u.multiple && (u.selectionAdapter = c.Decorate(u.selectionAdapter, s)), null != u.selectionCssClass && (u.selectionAdapter = c.Decorate(u.selectionAdapter, o)), u.selectionAdapter = c.Decorate(u.selectionAdapter, l)), u.language = this._resolveLanguage(u.language), u.language.push("en");
                        for (var D = [], E = 0; E < u.language.length; E++) {
                            var O = u.language[E]; - 1 === D.indexOf(O) && D.push(O)
                        }
                        return u.language = D, u.translations = this._processTranslations(u.language, u.debug), u
                    }, E.prototype.reset = function() {
                        function t(e) {
                            return e.replace(/[^\u0000-\u007E]/g, (function(e) {
                                return d[e] || e
                            }))
                        }
                        this.defaults = {
                            amdLanguageBase: "./i18n/",
                            autocomplete: "off",
                            closeOnSelect: !0,
                            debug: !1,
                            dropdownAutoWidth: !1,
                            escapeMarkup: c.escapeMarkup,
                            language: {},
                            matcher: function n(i, a) {
                                if (null == i.term || "" === i.term.trim()) return a;
                                if (a.children && a.children.length > 0) {
                                    for (var r = e.extend(!0, {}, a), s = a.children.length - 1; s >= 0; s--) {
                                        null == n(i, a.children[s]) && r.children.splice(s, 1)
                                    }
                                    return r.children.length > 0 ? r : n(i, r)
                                }
                                var o = t(a.text).toUpperCase(),
                                    l = t(i.term).toUpperCase();
                                return o.indexOf(l) > -1 ? a : null
                            },
                            minimumInputLength: 0,
                            maximumInputLength: 0,
                            maximumSelectionLength: 0,
                            minimumResultsForSearch: 0,
                            selectOnClose: !1,
                            scrollAfterSelect: !1,
                            sorter: function(e) {
                                return e
                            },
                            templateResult: function(e) {
                                return e.text
                            },
                            templateSelection: function(e) {
                                return e.text
                            },
                            theme: "default",
                            width: "resolve"
                        }
                    }, E.prototype.applyFromElement = function(e, t) {
                        var n = e.language,
                            i = this.defaults.language,
                            a = t.prop("lang"),
                            r = t.closest("[lang]").prop("lang"),
                            s = Array.prototype.concat.call(this._resolveLanguage(a), this._resolveLanguage(n), this._resolveLanguage(i), this._resolveLanguage(r));
                        return e.language = s, e
                    }, E.prototype._resolveLanguage = function(t) {
                        if (!t) return [];
                        if (e.isEmptyObject(t)) return [];
                        if (e.isPlainObject(t)) return [t];
                        var n;
                        n = Array.isArray(t) ? t : [t];
                        for (var i = [], a = 0; a < n.length; a++)
                            if (i.push(n[a]), "string" == typeof n[a] && n[a].indexOf("-") > 0) {
                                var r = n[a].split("-")[0];
                                i.push(r)
                            } return i
                    }, E.prototype._processTranslations = function(t, n) {
                        for (var i = new u, a = 0; a < t.length; a++) {
                            var r = new u,
                                s = t[a];
                            if ("string" == typeof s) try {
                                r = u.loadPath(s)
                            } catch (e) {
                                try {
                                    s = this.defaults.amdLanguageBase + s, r = u.loadPath(s)
                                } catch (e) {
                                    n && window.console && console.warn && console.warn('Select2: The language file for "' + s + '" could not be automatically loaded. A fallback will be used instead.')
                                }
                            } else r = e.isPlainObject(s) ? new u(s) : s;
                            i.extend(r)
                        }
                        return i
                    }, E.prototype.set = function(t, n) {
                        var i = {};
                        i[e.camelCase(t)] = n;
                        var a = c._convertData(i);
                        e.extend(!0, this.defaults, a)
                    }, new E
                })), t.define("select2/options", ["jquery", "./defaults", "./utils"], (function(e, t, n) {
                    function i(e, n) {
                        this.options = e, null != n && this.fromElement(n), null != n && (this.options = t.applyFromElement(this.options, n)), this.options = t.apply(this.options)
                    }
                    return i.prototype.fromElement = function(t) {
                        var i = ["select2"];
                        null == this.options.multiple && (this.options.multiple = t.prop("multiple")), null == this.options.disabled && (this.options.disabled = t.prop("disabled")), null == this.options.autocomplete && t.prop("autocomplete") && (this.options.autocomplete = t.prop("autocomplete")), null == this.options.dir && (t.prop("dir") ? this.options.dir = t.prop("dir") : t.closest("[dir]").prop("dir") ? this.options.dir = t.closest("[dir]").prop("dir") : this.options.dir = "ltr"), t.prop("disabled", this.options.disabled), t.prop("multiple", this.options.multiple), n.GetData(t[0], "select2Tags") && (this.options.debug && window.console && console.warn && console.warn('Select2: The `data-select2-tags` attribute has been changed to use the `data-data` and `data-tags="true"` attributes and will be removed in future versions of Select2.'), n.StoreData(t[0], "data", n.GetData(t[0], "select2Tags")), n.StoreData(t[0], "tags", !0)), n.GetData(t[0], "ajaxUrl") && (this.options.debug && window.console && console.warn && console.warn("Select2: The `data-ajax-url` attribute has been changed to `data-ajax--url` and support for the old attribute will be removed in future versions of Select2."), t.attr("ajax--url", n.GetData(t[0], "ajaxUrl")), n.StoreData(t[0], "ajax-Url", n.GetData(t[0], "ajaxUrl")));
                        var a = {};

                        function r(e, t) {
                            return t.toUpperCase()
                        }
                        for (var s = 0; s < t[0].attributes.length; s++) {
                            var o = t[0].attributes[s].name,
                                l = "data-";
                            if (o.substr(0, l.length) == l) {
                                var c = o.substring(l.length),
                                    u = n.GetData(t[0], c);
                                a[c.replace(/-([a-z])/g, r)] = u
                            }
                        }
                        e.fn.jquery && "1." == e.fn.jquery.substr(0, 2) && t[0].dataset && (a = e.extend(!0, {}, t[0].dataset, a));
                        var d = e.extend(!0, {}, n.GetData(t[0]), a);
                        for (var h in d = n._convertData(d)) i.indexOf(h) > -1 || (e.isPlainObject(this.options[h]) ? e.extend(this.options[h], d[h]) : this.options[h] = d[h]);
                        return this
                    }, i.prototype.get = function(e) {
                        return this.options[e]
                    }, i.prototype.set = function(e, t) {
                        this.options[e] = t
                    }, i
                })), t.define("select2/core", ["jquery", "./options", "./utils", "./keys"], (function(e, t, n, i) {
                    var a = function(e, i) {
                        null != n.GetData(e[0], "select2") && n.GetData(e[0], "select2").destroy(), this.$element = e, this.id = this._generateId(e), i = i || {}, this.options = new t(i, e), a.__super__.constructor.call(this);
                        var r = e.attr("tabindex") || 0;
                        n.StoreData(e[0], "old-tabindex", r), e.attr("tabindex", "-1");
                        var s = this.options.get("dataAdapter");
                        this.dataAdapter = new s(e, this.options);
                        var o = this.render();
                        this._placeContainer(o);
                        var l = this.options.get("selectionAdapter");
                        this.selection = new l(e, this.options), this.$selection = this.selection.render(), this.selection.position(this.$selection, o);
                        var c = this.options.get("dropdownAdapter");
                        this.dropdown = new c(e, this.options), this.$dropdown = this.dropdown.render(), this.dropdown.position(this.$dropdown, o);
                        var u = this.options.get("resultsAdapter");
                        this.results = new u(e, this.options, this.dataAdapter), this.$results = this.results.render(), this.results.position(this.$results, this.$dropdown);
                        var d = this;
                        this._bindAdapters(), this._registerDomEvents(), this._registerDataEvents(), this._registerSelectionEvents(), this._registerDropdownEvents(), this._registerResultsEvents(), this._registerEvents(), this.dataAdapter.current((function(e) {
                            d.trigger("selection:update", {
                                data: e
                            })
                        })), e[0].classList.add("select2-hidden-accessible"), e.attr("aria-hidden", "true"), this._syncAttributes(), n.StoreData(e[0], "select2", this), e.data("select2", this)
                    };
                    return n.Extend(a, n.Observable), a.prototype._generateId = function(e) {
                        return "select2-" + (null != e.attr("id") ? e.attr("id") : null != e.attr("name") ? e.attr("name") + "-" + n.generateChars(2) : n.generateChars(4)).replace(/(:|\.|\[|\]|,)/g, "")
                    }, a.prototype._placeContainer = function(e) {
                        e.insertAfter(this.$element);
                        var t = this._resolveWidth(this.$element, this.options.get("width"));
                        null != t && e.css("width", t)
                    }, a.prototype._resolveWidth = function(e, t) {
                        var n = /^width:(([-+]?([0-9]*\.)?[0-9]+)(px|em|ex|%|in|cm|mm|pt|pc))/i;
                        if ("resolve" == t) {
                            var i = this._resolveWidth(e, "style");
                            return null != i ? i : this._resolveWidth(e, "element")
                        }
                        if ("element" == t) {
                            var a = e.outerWidth(!1);
                            return a <= 0 ? "auto" : a + "px"
                        }
                        if ("style" == t) {
                            var r = e.attr("style");
                            if ("string" != typeof r) return null;
                            for (var s = r.split(";"), o = 0, l = s.length; o < l; o += 1) {
                                var c = s[o].replace(/\s/g, "").match(n);
                                if (null !== c && c.length >= 1) return c[1]
                            }
                            return null
                        }
                        return "computedstyle" == t ? window.getComputedStyle(e[0]).width : t
                    }, a.prototype._bindAdapters = function() {
                        this.dataAdapter.bind(this, this.$container), this.selection.bind(this, this.$container), this.dropdown.bind(this, this.$container), this.results.bind(this, this.$container)
                    }, a.prototype._registerDomEvents = function() {
                        var e = this;
                        this.$element.on("change.select2", (function() {
                            e.dataAdapter.current((function(t) {
                                e.trigger("selection:update", {
                                    data: t
                                })
                            }))
                        })), this.$element.on("focus.select2", (function(t) {
                            e.trigger("focus", t)
                        })), this._syncA = n.bind(this._syncAttributes, this), this._syncS = n.bind(this._syncSubtree, this), this._observer = new window.MutationObserver((function(t) {
                            e._syncA(), e._syncS(t)
                        })), this._observer.observe(this.$element[0], {
                            attributes: !0,
                            childList: !0,
                            subtree: !1
                        })
                    }, a.prototype._registerDataEvents = function() {
                        var e = this;
                        this.dataAdapter.on("*", (function(t, n) {
                            e.trigger(t, n)
                        }))
                    }, a.prototype._registerSelectionEvents = function() {
                        var e = this,
                            t = ["toggle", "focus"];
                        this.selection.on("toggle", (function() {
                            e.toggleDropdown()
                        })), this.selection.on("focus", (function(t) {
                            e.focus(t)
                        })), this.selection.on("*", (function(n, i) {
                            -1 === t.indexOf(n) && e.trigger(n, i)
                        }))
                    }, a.prototype._registerDropdownEvents = function() {
                        var e = this;
                        this.dropdown.on("*", (function(t, n) {
                            e.trigger(t, n)
                        }))
                    }, a.prototype._registerResultsEvents = function() {
                        var e = this;
                        this.results.on("*", (function(t, n) {
                            e.trigger(t, n)
                        }))
                    }, a.prototype._registerEvents = function() {
                        var e = this;
                        this.on("open", (function() {
                            e.$container[0].classList.add("select2-container--open")
                        })), this.on("close", (function() {
                            e.$container[0].classList.remove("select2-container--open")
                        })), this.on("enable", (function() {
                            e.$container[0].classList.remove("select2-container--disabled")
                        })), this.on("disable", (function() {
                            e.$container[0].classList.add("select2-container--disabled")
                        })), this.on("blur", (function() {
                            e.$container[0].classList.remove("select2-container--focus")
                        })), this.on("query", (function(t) {
                            e.isOpen() || e.trigger("open", {}), this.dataAdapter.query(t, (function(n) {
                                e.trigger("results:all", {
                                    data: n,
                                    query: t
                                })
                            }))
                        })), this.on("query:append", (function(t) {
                            this.dataAdapter.query(t, (function(n) {
                                e.trigger("results:append", {
                                    data: n,
                                    query: t
                                })
                            }))
                        })), this.on("keypress", (function(t) {
                            var n = t.which;
                            e.isOpen() ? n === i.ESC || n === i.UP && t.altKey ? (e.close(t), t.preventDefault()) : n === i.ENTER || n === i.TAB ? (e.trigger("results:select", {}), t.preventDefault()) : n === i.SPACE && t.ctrlKey ? (e.trigger("results:toggle", {}), t.preventDefault()) : n === i.UP ? (e.trigger("results:previous", {}), t.preventDefault()) : n === i.DOWN && (e.trigger("results:next", {}), t.preventDefault()) : (n === i.ENTER || n === i.SPACE || n === i.DOWN && t.altKey) && (e.open(), t.preventDefault())
                        }))
                    }, a.prototype._syncAttributes = function() {
                        this.options.set("disabled", this.$element.prop("disabled")), this.isDisabled() ? (this.isOpen() && this.close(), this.trigger("disable", {})) : this.trigger("enable", {})
                    }, a.prototype._isChangeMutation = function(e) {
                        var t = this;
                        if (e.addedNodes && e.addedNodes.length > 0)
                            for (var n = 0; n < e.addedNodes.length; n++) {
                                if (e.addedNodes[n].selected) return !0
                            } else {
                                if (e.removedNodes && e.removedNodes.length > 0) return !0;
                                if (Array.isArray(e)) return e.some((function(e) {
                                    return t._isChangeMutation(e)
                                }))
                            }
                        return !1
                    }, a.prototype._syncSubtree = function(e) {
                        var t = this._isChangeMutation(e),
                            n = this;
                        t && this.dataAdapter.current((function(e) {
                            n.trigger("selection:update", {
                                data: e
                            })
                        }))
                    }, a.prototype.trigger = function(e, t) {
                        var n = a.__super__.trigger,
                            i = {
                                open: "opening",
                                close: "closing",
                                select: "selecting",
                                unselect: "unselecting",
                                clear: "clearing"
                            };
                        if (void 0 === t && (t = {}), e in i) {
                            var r = i[e],
                                s = {
                                    prevented: !1,
                                    name: e,
                                    args: t
                                };
                            if (n.call(this, r, s), s.prevented) return void(t.prevented = !0)
                        }
                        n.call(this, e, t)
                    }, a.prototype.toggleDropdown = function() {
                        this.isDisabled() || (this.isOpen() ? this.close() : this.open())
                    }, a.prototype.open = function() {
                        this.isOpen() || this.isDisabled() || this.trigger("query", {})
                    }, a.prototype.close = function(e) {
                        this.isOpen() && this.trigger("close", {
                            originalEvent: e
                        })
                    }, a.prototype.isEnabled = function() {
                        return !this.isDisabled()
                    }, a.prototype.isDisabled = function() {
                        return this.options.get("disabled")
                    }, a.prototype.isOpen = function() {
                        return this.$container[0].classList.contains("select2-container--open")
                    }, a.prototype.hasFocus = function() {
                        return this.$container[0].classList.contains("select2-container--focus")
                    }, a.prototype.focus = function(e) {
                        this.hasFocus() || (this.$container[0].classList.add("select2-container--focus"), this.trigger("focus", {}))
                    }, a.prototype.enable = function(e) {
                        this.options.get("debug") && window.console && console.warn && console.warn('Select2: The `select2("enable")` method has been deprecated and will be removed in later Select2 versions. Use $element.prop("disabled") instead.'), null != e && 0 !== e.length || (e = [!0]);
                        var t = !e[0];
                        this.$element.prop("disabled", t)
                    }, a.prototype.data = function() {
                        this.options.get("debug") && arguments.length > 0 && window.console && console.warn && console.warn('Select2: Data can no longer be set using `select2("data")`. You should consider setting the value instead using `$element.val()`.');
                        var e = [];
                        return this.dataAdapter.current((function(t) {
                            e = t
                        })), e
                    }, a.prototype.val = function(e) {
                        if (this.options.get("debug") && window.console && console.warn && console.warn('Select2: The `select2("val")` method has been deprecated and will be removed in later Select2 versions. Use $element.val() instead.'), null == e || 0 === e.length) return this.$element.val();
                        var t = e[0];
                        Array.isArray(t) && (t = t.map((function(e) {
                            return e.toString()
                        }))), this.$element.val(t).trigger("input").trigger("change")
                    }, a.prototype.destroy = function() {
                        n.RemoveData(this.$container[0]), this.$container.remove(), this._observer.disconnect(), this._observer = null, this._syncA = null, this._syncS = null, this.$element.off(".select2"), this.$element.attr("tabindex", n.GetData(this.$element[0], "old-tabindex")), this.$element[0].classList.remove("select2-hidden-accessible"), this.$element.attr("aria-hidden", "false"), n.RemoveData(this.$element[0]), this.$element.removeData("select2"), this.dataAdapter.destroy(), this.selection.destroy(), this.dropdown.destroy(), this.results.destroy(), this.dataAdapter = null, this.selection = null, this.dropdown = null, this.results = null
                    }, a.prototype.render = function() {
                        var t = e('<span class="select2 select2-container"><span class="selection"></span><span class="dropdown-wrapper" aria-hidden="true"></span></span>');
                        return t.attr("dir", this.options.get("dir")), this.$container = t, this.$container[0].classList.add("select2-container--" + this.options.get("theme")), n.StoreData(t[0], "element", this.$element), t
                    }, a
                })), t.define("select2/dropdown/attachContainer", [], (function() {
                    function e(e, t, n) {
                        e.call(this, t, n)
                    }
                    return e.prototype.position = function(e, t, n) {
                        n.find(".dropdown-wrapper").append(t), t[0].classList.add("select2-dropdown--below"), n[0].classList.add("select2-container--below")
                    }, e
                })), t.define("select2/dropdown/stopPropagation", [], (function() {
                    function e() {}
                    return e.prototype.bind = function(e, t, n) {
                        e.call(this, t, n);
                        this.$dropdown.on(["blur", "change", "click", "dblclick", "focus", "focusin", "focusout", "input", "keydown", "keyup", "keypress", "mousedown", "mouseenter", "mouseleave", "mousemove", "mouseover", "mouseup", "search", "touchend", "touchstart"].join(" "), (function(e) {
                            e.stopPropagation()
                        }))
                    }, e
                })), t.define("select2/selection/stopPropagation", [], (function() {
                    function e() {}
                    return e.prototype.bind = function(e, t, n) {
                        e.call(this, t, n);
                        this.$selection.on(["blur", "change", "click", "dblclick", "focus", "focusin", "focusout", "input", "keydown", "keyup", "keypress", "mousedown", "mouseenter", "mouseleave", "mousemove", "mouseover", "mouseup", "search", "touchend", "touchstart"].join(" "), (function(e) {
                            e.stopPropagation()
                        }))
                    }, e
                })),
                /*!
                 * jQuery Mousewheel 3.1.13
                 *
                 * Copyright jQuery Foundation and other contributors
                 * Released under the MIT license
                 * http://jquery.org/license
                 */
                n = function(e) {
                    var t, n, i = ["wheel", "mousewheel", "DOMMouseScroll", "MozMousePixelScroll"],
                        a = "onwheel" in document || document.documentMode >= 9 ? ["wheel"] : ["mousewheel", "DomMouseScroll", "MozMousePixelScroll"],
                        r = Array.prototype.slice;
                    if (e.event.fixHooks)
                        for (var s = i.length; s;) e.event.fixHooks[i[--s]] = e.event.mouseHooks;
                    var o = e.event.special.mousewheel = {
                        version: "3.1.12",
                        setup: function() {
                            if (this.addEventListener)
                                for (var t = a.length; t;) this.addEventListener(a[--t], l, !1);
                            else this.onmousewheel = l;
                            e.data(this, "mousewheel-line-height", o.getLineHeight(this)), e.data(this, "mousewheel-page-height", o.getPageHeight(this))
                        },
                        teardown: function() {
                            if (this.removeEventListener)
                                for (var t = a.length; t;) this.removeEventListener(a[--t], l, !1);
                            else this.onmousewheel = null;
                            e.removeData(this, "mousewheel-line-height"), e.removeData(this, "mousewheel-page-height")
                        },
                        getLineHeight: function(t) {
                            var n = e(t),
                                i = n["offsetParent" in e.fn ? "offsetParent" : "parent"]();
                            return i.length || (i = e("body")), parseInt(i.css("fontSize"), 10) || parseInt(n.css("fontSize"), 10) || 16
                        },
                        getPageHeight: function(t) {
                            return e(t).height()
                        },
                        settings: {
                            adjustOldDeltas: !0,
                            normalizeOffset: !0
                        }
                    };

                    function l(i) {
                        var a = i || window.event,
                            s = r.call(arguments, 1),
                            l = 0,
                            d = 0,
                            h = 0,
                            f = 0,
                            p = 0,
                            g = 0;
                        if ((i = e.event.fix(a)).type = "mousewheel", "detail" in a && (h = -1 * a.detail), "wheelDelta" in a && (h = a.wheelDelta), "wheelDeltaY" in a && (h = a.wheelDeltaY), "wheelDeltaX" in a && (d = -1 * a.wheelDeltaX), "axis" in a && a.axis === a.HORIZONTAL_AXIS && (d = -1 * h, h = 0), l = 0 === h ? d : h, "deltaY" in a && (l = h = -1 * a.deltaY), "deltaX" in a && (d = a.deltaX, 0 === h && (l = -1 * d)), 0 !== h || 0 !== d) {
                            if (1 === a.deltaMode) {
                                var m = e.data(this, "mousewheel-line-height");
                                l *= m, h *= m, d *= m
                            } else if (2 === a.deltaMode) {
                                var v = e.data(this, "mousewheel-page-height");
                                l *= v, h *= v, d *= v
                            }
                            if (f = Math.max(Math.abs(h), Math.abs(d)), (!n || f < n) && (n = f, u(a, f) && (n /= 40)), u(a, f) && (l /= 40, d /= 40, h /= 40), l = Math[l >= 1 ? "floor" : "ceil"](l / n), d = Math[d >= 1 ? "floor" : "ceil"](d / n), h = Math[h >= 1 ? "floor" : "ceil"](h / n), o.settings.normalizeOffset && this.getBoundingClientRect) {
                                var y = this.getBoundingClientRect();
                                p = i.clientX - y.left, g = i.clientY - y.top
                            }
                            return i.deltaX = d, i.deltaY = h, i.deltaFactor = n, i.offsetX = p, i.offsetY = g, i.deltaMode = 0, s.unshift(i, l, d, h), t && clearTimeout(t), t = setTimeout(c, 200), (e.event.dispatch || e.event.handle).apply(this, s)
                        }
                    }

                    function c() {
                        n = null
                    }

                    function u(e, t) {
                        return o.settings.adjustOldDeltas && "mousewheel" === e.type && t % 120 == 0
                    }
                    e.fn.extend({
                        mousewheel: function(e) {
                            return e ? this.bind("mousewheel", e) : this.trigger("mousewheel")
                        },
                        unmousewheel: function(e) {
                            return this.unbind("mousewheel", e)
                        }
                    })
                }, "function" == typeof t.define && t.define.amd ? t.define("jquery-mousewheel", ["jquery"], n) : "object" == typeof exports ? module.exports = n : n(e), t.define("jquery.select2", ["jquery", "jquery-mousewheel", "./select2/core", "./select2/defaults", "./select2/utils"], (function(e, t, n, i, a) {
                    if (null == e.fn.select2) {
                        var r = ["open", "close", "destroy"];
                        e.fn.select2 = function(t) {
                            if ("object" == typeof(t = t || {})) return this.each((function() {
                                var i = e.extend(!0, {}, t);
                                new n(e(this), i)
                            })), this;
                            if ("string" == typeof t) {
                                var i, s = Array.prototype.slice.call(arguments, 1);
                                return this.each((function() {
                                    var e = a.GetData(this, "select2");
                                    null == e && window.console && console.error && console.error("The select2('" + t + "') method was called on an element that is not using Select2."), i = e[t].apply(e, s)
                                })), r.indexOf(t) > -1 ? this : i
                            }
                            throw new Error("Invalid arguments for Select2: " + t)
                        }
                    }
                    return null == e.fn.select2.defaults && (e.fn.select2.defaults = i), n
                })), {
                    define: t.define,
                    require: t.require
                }
        }(),
        n = t.require("jquery.select2");
    return e.fn.select2.amd = t, n
})), $.fn.select2.defaults.set("theme", "bootstrap5"), $.fn.select2.defaults.set("width", "100%"), $.fn.select2.defaults.set("selectionCssClass", ":all:")