var Fancytree = function() {
    var _componentFancytree = function() {
        if (!$().fancytree) {
            console.warn('Warning - fancytree_all.min.js is not loaded.');
            return;
        }
        $('.tree-default').fancytree({
            init: function(event, data) {
                $('.has-tooltip .fancytree-title').tooltip();
            }
        });
    };
    return {
        init: function() {
            _componentFancytree();
        }
    }
}();
document.addEventListener('DOMContentLoaded', function() {
    Fancytree.init();
});
