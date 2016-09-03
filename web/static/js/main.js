(function () {
    'use strict';
    $(document).ready(function() {
        $('#fullpage').fullpage({
            anchors: ['', 'about', 'children', 'adult', 'business', 'contacts'],
            //menu: '.top.honeycombs_container',
            normalScrollElements: '.scrollable',
            animateAnchor: true,
            //scrollOverflow: true,
            css3: true,
            onLeave: function(){
                if (document.querySelector('a.nav.active')) {
                    setTimeout(function () {
                        topHoneycombsContainers.forEach(function(val) {
                            val.querySelector('a.nav.active').classList.remove('active');
                        });
                    }, 350);
                }
            },
            afterLoad: function(anchorLink){
                //var activeSection = document.querySelector('section.active');
                if (anchorLink !== '' &&
                    document.querySelector('section.'+anchorLink).classList.contains('directions') &&
                    document.querySelector('section.'+anchorLink).classList.contains('active')) {
                    topHoneycombsContainers.forEach(function(val) {
                        val.querySelector('a.nav[data-menuanchor='+anchorLink+']').classList.add('active');
                    });
                }
            },
            scrollingSpeed: 800
        });
    });
    var topHoneycombsContainers = document.querySelectorAll('.top .honeycombs_container'),
        botHoneycombsContainers = document.querySelectorAll('.bottom .honeycombs_container'),
        articles = document.querySelectorAll('.article'),
        text = document.querySelectorAll('.text');

    function isShown(container) {
        return container.getElementsByClassName('active')[0];
    }

    function showOff(event) {
        if (event.target.classList.contains('honeycomb') &&
            !event.target.classList.contains('nav')) {
            var that = this;
            if (isShown(that.children[2])) return false;
            //var title =
            that.children[0].style.opacity = 1;
            console.log('ShowOff');
            if (window.matchMedia("(orientation: landscape)").matches) {
                that.children[1].style.width = '40%';
                that.children[2].style.width = '60%';
            }
            that.children[2].children[2].style.left = '-100vw';
            that.children[2].children[3].style.left = 0;
            that.children[2].children[4].style.left = 0;
        }
    }

    function hide(event) {
        if(event.target.className == "cross") {
            var that = this;
            console.log('Hide');
            that.children[0].style.opacity = 0;
            setTimeout(function () {
                if (window.matchMedia("(orientation: landscape)").matches) {
                    that.children[1].style.width = '50%';
                    that.children[2].style.width = '50%';
                }
                that.children[2].children[2].style.left = '0';
                that.children[2].children[3].style.left = '100%';
                that.children[2].children[4].style.left = '100%';
            }, 150);
        }
    }

    var form = document.getElementById('form');
    if (form) var fields = form.getElementsByClassName('validate');

    var sections = document.querySelectorAll('.animate');
    window.onload = function() {
        "use strict";
        if (form) form.addEventListener('submit', submit);
        for (var i = 0; i < sections.length; i++) {
            sections[i].children[0].addEventListener('click', showOff);
            sections[i].children[0].addEventListener('click', hide);
        }
        if (fields)
            for (i = 0; i < fields.length; i++) {
                fields[i].addEventListener('input', validate);
                fields[i].addEventListener('blur', validate);
            }
    };



    function submit(event) {
        event.preventDefault();

        var serialized = serialize(form, {hash: true});
        console.log(serialized);
        this.getElementsByTagName('input')[0].focus();

        return false;
    }

    function validate(event) {
        var necessary = event.target.hasAttribute('required');

        if (necessary) {
            event.target.classList.remove('error');
            if (event.target.value.trim().length == 0) {
                event.target.classList.add('error');
            }
        }

        if (!necessary) {
            var unnecessaryFields = form.querySelectorAll('input.validate:not([required])');
            for (var i = 0; i < unnecessaryFields.length; i++) {
                unnecessaryFields[i].classList.remove('warning');
            }

            var emptyUnnecessaryFields = form.querySelectorAll('input.validate:not([required]):not([value])');
            console.log(emptyUnnecessaryFields);
            if (emptyUnnecessaryFields.length > 1) {
                for (i = 0; i < unnecessaryFields.length; i++) {
                    unnecessaryFields[i].classList.add('warning');
                }
            }
        }
    }

    /*jshint ignore:end*/
}());
