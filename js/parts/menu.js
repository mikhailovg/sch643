$(function() {
    function getMenuItems(parentId, callback){
        $.ajax({
            url: "/php/actions/shared/getPages.php",
            data: {
                parentId: parentId
            },
            type: 'POST',
            success: function(nodes){
                callback(nodes);
            }

        });
    }

    function renderMenuItems(menuContainer, nodes, pageContainer){
        menuContainer.find('ul').remove();
        var listUi=$('<ul class="drop_vert_menu"></ul>');
        for(var i=0; i<nodes.length; ++i){
            var nodeUi=$('<li><a href="#"><span>'+nodes[i].name+'</span></a></li>');

            nodeUi.hover(
                function(nodeUi, node){
                    return function(){
                        getMenuItems(node.id,function(items){
                            renderMenuItems(nodeUi,items,pageContainer);
                        });
                        nodeUi.find('a').css('padding', '0 16px');
                    }
                }(nodeUi,nodes[i]),
                function(nodeUi, node) {
                    return function(){
                        nodeUi.find('a').css('padding', '0 6px');
                    }
                }(nodeUi,nodes[i])
            );

            nodeUi.click(function(node){
                return function(e){
                   e.stopPropagation();
                   getPage(node.id, function(page){
                       renderPage(pageContainer,page);
                   })
                }
            }(nodes[i]));
            listUi.append(nodeUi);

            var styles;
            if (i == 0) {
                styles = {
                    'border-top-left-radius': '5px',
                    'border-top-right-radius': '5px'
                };
                $(nodeUi).find('a').css(styles);
            } else if (i == nodes.length - 1) {
                styles = {
                    'border-bottom-right-radius': '5px'
                };
                $(nodeUi).find('a').css(styles);
            }

        }
        menuContainer.append(listUi);
    }

    function getPage(pageId,callback){
       /* if (pageId==19)
            location.href='http://643spb.edusite.ru/php/pages/news/articles.php';*/
       /* else
            location.href='http://643spb.edusite.ru/php/actions/shared/getPage.php?id='+pageId;*/
        $.ajax({
            url: "/php/actions/shared/getPage.php",
            data: {
                id: pageId
            },
            type: 'GET',
            success: function(page){
                if(page)
                    callback(page[0]);
            }

        });
    }

    function renderPage(pageContainer, page){
       pageContainer.html(page.htmlContent);
    }

    getMenuItems(0, function(items){
        renderMenuItems($('.navmenu-v'),items,$('#page_container'));
    });
});