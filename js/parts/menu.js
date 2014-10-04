$(function() {
    //$('.menu_hor').liMenuHor();




    function getMenuItems(parentId, callback){
        $.ajax({
            url: "/admin/getPagesByParent",
            data: {
                    parentId: parentId
            },
            type: 'GET',
            success: function(nodes){
                callback(nodes);
            }

        });
    }


    function renderMenuItems(menuContainer, nodes){
        menuContainer.find('ul').remove();
        var listUi=$('<ul class="drop_vert_menu"></ul>');
        for(var i=0; i<nodes.length; ++i){
            var nodeUi=$('<li><a href="#"><span>'+nodes[i].name+'</span></a></li>');
            nodeUi.hover(function(nodeUi,node){
                return function(){
                    getMenuItems(node.id,function(items){
                        renderMenuItems(nodeUi,items);
                    });
                }
            }(nodeUi,nodes[i])/*, function(){
                $(this).find('ul').remove();
            }*/);
            listUi.append(nodeUi);
        }
        menuContainer.append(listUi);
    }

    getMenuItems(0, function(items){
        renderMenuItems($('.navmenu-v'),items);
    });
});