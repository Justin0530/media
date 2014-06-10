/**
 * Created by justin on 14-6-10.
 */
/*
 * Chained - jQuery non AJAX(J) chained selects plugin
 *
 * Copyright (c) 2010-2011 Mika Tuupola
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 */
function chainedSelect(select){
    if(select[3]){
        $(select[3]).chained(select[2], select[3]);
        $(select[2]).chained(select[1], select[2]);
        $(select[1]).chained(select[0], select[1]);
    }
    else if(select[2]){
        $(select[2]).chained(select[1], select[2]);
        $(select[1]).chained(select[0], select[1]);
    }else{
        $(select[1]).chained(select[0], select[1]);
    }
}

(function($) {

    //$.fn.chained = function(parent_selector, terminal, options) {
    $.fn.chained = function(parent_selector, selector, options) {

        $(selector + ' option').each(function(){
            if( $(this).attr('selected') == 'selected' ){
                var parentElementValue = $(this).attr('class');
                $(parent_selector + ' option').each(function(){
                    if( $(this).attr('value') == parentElementValue ){
                        $(this).attr('selected','selected')
                    }
                });
            }


        });
        /*
         $(terminal + ' option').each(function(){
         if( $(this).attr('selected') == 'selected' ){
         var parentElementValue = $(this).attr('class');
         $(parent_selector + ' option').each(function(){
         if( $(this).attr('value') == parentElementValue ){
         $(this).attr('selected','selected')
         }
         });
         }
         });
         */

        return this.each(function() {

            /* Save this to self because this changes when scope changes. */
            var self   = this;
            var backup = $(self).clone();

            /* Handles maximum two parents now. */
            $(parent_selector).each(function() {

                $(this).bind("change", function() {
                    $(self).html(backup.html());

                    /* If multiple parents build classname like foo\bar. */
                    var selected = "";
                    $(parent_selector).each(function() {
                        selected += "\\" + $(":selected", this).val();
                    });
                    selected = selected.substr(1);

                    /* Also check for first parent without subclassing. */
                    /* TODO: This should be dynamic and check for each parent */
                    /*       without subclassing. */
                    var first = $(parent_selector).first();
                    var selected_first = $(":selected", first).val();

                    $("option", self).each(function() {
                        /* Remove unneeded items but save the default value. */
                        if (!$(this).hasClass(selected) &&
                            !$(this).hasClass(selected_first) && $(this).val() !== "") {
                            $(this).remove();
                        }
                    });

                    /* If we have only the default value disable select. */
                    if (1 == $("option", self).size() && $(self).val() === "") {
                        $(self).attr("disabled", "disabled");
                    } else {
                        $(self).removeAttr("disabled");
                    }
                    $(self).trigger("change");
                });

                /* Force IE to see something selected on first page load, */
                /* unless something is already selected */
                if ( !$("option:selected", this).length ) {
                    $("option", this).first().attr("selected", "selected");
                }

                /* Force updating the children. */
                $(this).trigger("change");

            });
        });
    };

    /* Alias for those who like to use more English like syntax. */
    $.fn.chainedTo = $.fn.chained;

})(jQuery);

