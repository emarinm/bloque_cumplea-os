define('block_bcn_birthdays_section/ajaxcalls',['jquery', 'core/notification', 'core/ajax'],
    function ($, notification, ajax) {

        function Ajaxcall() {
            this.value = "ajax ok";
        };

        Ajaxcall.prototype.get_config = function(contextid) {

            const promises = ajax.call([{
                methodname: 'block_bcn_birthdays_section_get_config',
                args: {   contextid : contextid},
            }]);

            return promises[0];
        };
        
        return Ajaxcall;
    });