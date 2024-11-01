/**
 * @package Wordpress SmileBox Widget
 * @author Igor Karpov <mail@noxls.net>
 * @link https://noxls.net
 *
 */

jQuery(document).mouseup(function (e) {
    var container = jQuery(".nxIK-commentlist");
    var smile = jQuery("#nxik-smile");
    if(smile.is(e.target)) {
        container.toggle();
    }
    else if (!container.is(e.target) && container.has(e.target).length === 0) {
        container.hide();
    }

});