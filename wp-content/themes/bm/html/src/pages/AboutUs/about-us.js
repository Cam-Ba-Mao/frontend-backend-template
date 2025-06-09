(function ($) {
    const introSec = ".rt-intro";
    const discoverSec = ".rt-discover";
    const videoSel = introSec + " .video-wrapper";
    const maskSel = videoSel + " .mask";
    const sliderSel = discoverSec + "__inner--slider__main";
    const thumbSel = discoverSec + "__inner--slider__thumbs";
    const nextSel = discoverSec + "__inner--slider__next";
    const prevSel = discoverSec + "__inner--slider__prev";
    const textSel = discoverSec + " .text-line";
    const slideActiveSel = discoverSec + " .swiper-slide.swiper-slide-active";
    const btnSel = 'rt-btn-primary';
    const heroLineCls = 'hero-effect__line';
    const heroLetterCls = 'hero-effect__letter';
    const dividers = ['!', ',', '.', '&', '+', '=', '/', '\\', '<', '>', '*', '-'];
    const limits = {
        480: 3,
        576: 4,
        767: 5,
        992: 6,
        1200: 7,
        1400: 8,
        1600: 9,
    };
    const delayTime = 0.1;
    const letterRatio = 1.15;

    let about = {
        execute: function (selector, callback) {
            let elem = document.querySelectorAll(selector);

            if (elem.length === 0) {
                return false;
            }

            if (typeof (callback) === 'function') {
                callback(selector, elem);
            }
        },
        init: function () {
            about.handleVideo(maskSel);
            about.handleSlider(sliderSel);
            about.handleResize();
        },
        handleResize: function () {
            window.addEventListener('resize', function () {
                about.handleWordEffect(textSel);
            });
        },
        checkString: function (str, callback) {
            if (str === '' || str === null) {
                return false;
            }
            if (typeof (str) === 'string' || typeof (str) === 'object') {
                if (typeof (callback) === 'function') {
                    callback(str);
                }
            }
        },
        getStrWidth: function (str) {
            let textElem = document.querySelector(textSel), span = null;
            let finals = 0.000;
            if (textElem === null) {
                return false;
            }

            //create a temporary span to calculate word width
            span = document.createElement('span');
            span.innerHTML = str;
            span.style.position = 'absolute';
            span.style.opacity = "0";

            //Temporarily append span to text element for calculating, then remove it
            textElem.appendChild(span);
            finals = about.getElemWidth(span, false);
            //console.log('STRING WIDTH: ', finals);
            textElem.removeChild(span);
            return finals;
        },
        getElemWidth: function (selector, isAll = false) {
            if (selector === "" || selector === null || typeof (selector) === 'undefined')
                return 0;

            let result = null, widthWithPaddings = 0.000, elem = null;

            if (typeof (selector) === 'object' || typeof (selector) === 'string') {
                if (typeof (selector) === 'object') {
                    elem = selector;
                }

                if (typeof (selector) === 'string') {
                    if (isAll) {
                        elem = document.querySelectorAll(selector);
                    }
                    else {
                        elem = document.querySelector(selector);
                    }
                }
            }
            if (elem === null)
                return false;

            if (!isAll) {
                result = about.getBaseWidth(elem);
            }
            else {
                let widths = [];
                for (const el of elem) {
                    widths.push(about.getBaseWidth(el));
                }
                result = widths;
            }

            return result;
        },
        getBaseWidth: function (elem) {
            let result = 0.000;
            if (elem === null || typeof (elem) === 'undefined' || typeof (elem) !== 'object')
                return result;

            let widthPadding = elem.getBoundingClientRect().width;
            const elemComputedStyle = window.getComputedStyle(elem, null);
            result = Math.ceil(widthPadding - (parseFloat(elemComputedStyle.paddingLeft) + parseFloat(elemComputedStyle.paddingRight))) * letterRatio;

            return result;
        },
        countWords: function (str) {
            about.checkString(str, function (str) {
                let count = str.trim().split(/\s+/).length;
                return count;
            });
        },
        splitWords: function (str) {
            if (str === '' || str === null || typeof (str) === 'undefined')
                return [];

            let words = [], regex = /\s+/;

            words = str.trim().split(regex);
            return words;
        },
        splitLines: function (wordsArr, totalWidth) {
            if (wordsArr === null || typeof (wordsArr) === 'undefined' || !Array.isArray(wordsArr))
                return false;

            let baseWidth = 0.000, count = wordsArr.length, line = [], totalLines = [], i = 0;
            do {
                let word = wordsArr[i], width = 0.000;
                if (i < count - 1)
                    word += " ";
                width = about.getStrWidth(word);
                baseWidth += width;
                line.push(word);
                //console.log(line);
                if (baseWidth > totalWidth) {
                    let recalWidth = about.getStrWidth(word.trim());
                    if ((baseWidth - width + recalWidth * 1 / letterRatio) > totalWidth) {
                        line.pop(word);
                        baseWidth = width;
                        totalLines.push(line);
                        line = [];
                        //console.log("word:|" + word + "|");
                        line.push(word);
                    }
                    else {
                        baseWidth = baseWidth - width + recalWidth * 1 / letterRatio;
                        line.pop(word);
                        line.push(word.trim());
                    }
                }
                if (i === count - 1) {
                    totalLines.push(line);
                }

                i++;
            } while (i <= count - 1);
            //console.log("totalLines:", totalLines);
            return totalLines;
        },
        handleLinesBreaker: function (str) {
            var width = $(window).width(), wrapperWidth = $(textSel).width(), size = '';

            for (const [key, value] of Object.entries(limits)) {
                if (width >= key)
                    size = key;
            }
            let wordsArr = about.splitWords(str);
            return about.splitLines(wordsArr, wrapperWidth);
        },
        handleWordEffect: function (selector, elem) {
            about.execute(selector, function (selector, elem) {

                elem.forEach((item, index) => {
                    let lines = [],
                        type = item.tagName,
                        isBtn = false,
                        regEx = /\r?\n|\r|\n/g;
                    var baseDelay = delayTime;

                    isBtn = (type.toLowerCase() === 'a') && item.classList.contains(btnSel);

                    if (isBtn) {//if customized button get first child's text content
                        lines = item.firstChild !== null ? item.firstChild.textContent.split(regEx) : item.textContent.split(regEx);

                        lines.forEach((line) => {
                            let newLine = document.createElement('div');
                            newLine.classList.add(heroLineCls);
                            for (let i = 0; i < line.length; i++) {
                                let letter = document.createElement('span');
                                let bonusDelay = i * 0.1;

                                letter.classList.add(heroLetterCls);
                                letter.innerText = line[i];
                                letter.style.setProperty('--delay', (delayTime + bonusDelay) + 's');
                                newLine.appendChild(letter); //add each character element to the new line

                                //add each character element to first child of element
                                item.replaceChild(newLine, item.firstChild);
                            }
                        });

                    }
                    else {//else get element's text content
                        lines = about.handleLinesBreaker(item.textContent);
                        //lines = item.textContent.split(regEx);
                        item.innerHTML = "";

                        if (!Array.isArray(lines))
                            return false;

                        lines.forEach((line) => {
                            let newLine = document.createElement('div');
                            newLine.classList.add(heroLineCls);
                            let indexDelay = 0.01;
                            baseDelay += indexDelay;

                            //traversing the characters of text to add delay
                            for (let i = 0; i < line.length; i++) {
                                for (let j = 0; j < line[i].length; j++) {
                                    let letter = document.createElement('span');
                                    let letterDelay = 0.01;
                                    baseDelay += letterDelay;
                                    letter.classList.add(heroLetterCls);
                                    letter.innerHTML = line[i][j];
                                    letter.style.setProperty('--delay', baseDelay + 's');
                                    newLine.appendChild(letter); //add each character element to the new line
                                }
                            }

                            //add each character element to the element
                            item.appendChild(newLine);
                        });
                    }
                });
            });
        },
        handleVideo: function (selector) {
            about.execute(selector, function (selector, elem) {
                elem.forEach((item) => {
                    item.addEventListener('click', function (e) {
                        e.preventDefault();
                        let sources, gallery;

                        sources = this.dataset.sources;
                        sources = JSON.parse(sources);
                        gallery = window.lightGallery(item, {
                            dynamic: true,
                            plugins: [lgVideo, lgAutoplay, lgThumbnail],
                            dynamicEl: sources,
                            download: false,
                            counter: false,
                            slideShowAutoplay: (sources.length > 1 ? true : false),
                            autoplayControls: false,
                            autoplayVideoOnSlide: true,
                            showCloseIcon: true,
                            mobileSettings: {
                                controls: true,
                                showCloseIcon: true
                            }
                        });
                        gallery.openGallery(0);
                    });
                });
            });
        },
        handleSlider: function (selector, elem) {
            about.execute(selector, function (selector, elem) {
                elem.forEach((item) => {
                    let swiper = new Swiper(selector, {
                        speed: 0,
                        slidesPerView: 1,
                        spaceBetween: 24,
                        loop: true,
                        centeredSlides: true,
                        allowTouchMove: false,
                        pagination: {
                            el: thumbSel,
                            clickable: true,
                        },
                        navigation: {
                            nextEl: nextSel,
                            prevEl: prevSel,
                        },
                        on: {
                            afterInit: function (e) {
                                about.handleWordEffect(textSel);
                            }
                        }
                    });
                });
            });
        },
    };

    $(function () {
        about.init();
    });
})(jQuery);