/*jshint ignore:start*/
(function(window) {
    'use strict';
    var container = document.querySelector('.main_loader_container'),
        initContainer = [
            document.getElementById('authors'),
            document.getElementById('visitors'),
            document.getElementById('children'),
            document.getElementById('adult'),
            document.getElementById('business')
        ];

    window.store = {};

    function load(path) {
        console.log("path: ", path);
    }

    function loadArticle(articleName) {
        if (articleName !== null && typeof articleName === 'object') {
            articleName = articleName.target.innerText;
        }
        console.log("articleName: ", articleName);
        load('blog/articles/'+ articleName).then(function(snapshot) {
            var articleObj = snapshot.val(),
                title = document.getElementById('title'),
                author = document.getElementById('author'),
                topics = document.getElementById('topics'),
                article = document.getElementById('article');
            console.log("articleObj: ", articleObj);
            title.innerText = articleName;
            author.innerText = articleObj.author;
            article.innerText = articleObj.article;
            topics.innerHTML = "";
            articleObj.topics.forEach(function(topic) {
               var top = document.createElement('p');
                top.innerText = topic;
                topics.appendChild(top);
            });
            displaySpinner();
        }, function(error) {
            console.log("error: ", error);
        })
    }

    function initData() {
        var promises = [
            load('blog/authors'),
            load('blog/visitors'),
            load('blog/articles_list/children'),
            load('blog/articles_list/adult'),
            load('blog/articles_list/business')
        ];
        return Promise.all(promises);
    }

    function activate(event) {
        var articleName = event.target.innerText;
        console.log("activate.articleName: ", articleName);
        displaySpinner();
        loadArticle(articleName);
        if (store.lastActive) {
            store.lastActive.classList.remove('activate');
        }
        event.target.classList.add('activate');
        store.lastActive = event.target;
    }

    function displaySpinner() {
        var spinner = document.getElementById('spinner');
        if (spinner.style.display == 'none') { //display spinner
            spinner.style.display = "block";
        } else { // hide spinner
            spinner.style.display = "none";
        }
    }

    document.getElementById('all').addEventListener('click', readAll);

    function readAll() {
        if (document.getElementById('article').style.height == "30%") {
            document.getElementById('article').style.height = '70%';
        } else {
            document.getElementById('article').style.height = '30%';
        }
    }

    initData().then(
        function(values) {
            container.style.opacity = '0';
            setTimeout(function() {
                document.querySelector('body').removeChild(container);
            }, 2000);
            values.forEach(function(snapshot, index) {
                var list = snapshot.val();
                list.forEach(function(elem) {
                    var domElem = document.createElement('p');
                    domElem.innerText = elem;
                    domElem.addEventListener('click', loadArticle);
                    domElem.addEventListener('click', activate);
                    initContainer[index].appendChild(domElem);
                });
            });
        }, function(error) {
            var err = document.createElement('p');
            Array.from(container.children).forEach(function(child) {
                child.style.display = "none";
            });
            err.innerText = "Something went wrong, sorry <br>"+error;
            container.appendChild(err);
        }
    );
    loadArticle('Lorem Ipsum');
})(window);
/*jshint ignore:end*/
