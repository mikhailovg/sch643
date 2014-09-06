$(function() {
   var hoverTimeout;
   $('.menu__primary-items .menu__item').on('mouseout', function() {
       clearTimeout(hoverTimeout);
   });
   $('.menu__primary-items .menu__item').on('mouseover', function() {

       var primaryMenuItem = $(this),
           primaryMenuItemIndex = primaryMenuItem.prevAll('.menu__item').length,
           secondaryMenuItemsOfPrimarySelectItem = $('.menu__secondary-items, .menu__no-secondary-items').eq(primaryMenuItemIndex);

       if (secondaryMenuItemsOfPrimarySelectItem.is(':visible') || secondaryMenuItemsOfPrimarySelectItem.is('.menu__no-secondary-items')) return;

       hoverTimeout = setTimeout(function() {
           secondaryMenuItemsOfPrimarySelectItem
               .fadeIn({queue: false})
               .siblings('.menu__secondary-items:visible')
               .fadeOut();
       }, 400);
   });
});