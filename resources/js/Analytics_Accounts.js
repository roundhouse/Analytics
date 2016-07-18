/**
 * Analytics plugin for Craft CMS
 *
 * Analytics JS
 *
 * @author    Vadim Goncharov
 * @copyright Copyright (c) 2016 Vadim Goncharov
 * @link      http://roundhouseagency.com
 * @package   Analytics
 * @since     1.0.0
 */


(function($){

Craft.GoogleAnalyticsProperty = Garnish.Base.extend(
{
  accountId: null,
  propertyId: null,
  fieldId: null,
  $spinner: null,

  init: function(accountId, propertyId, fieldId)
  {
    that = this;
    this.accountId = accountId;
    this.propertyId = propertyId;
    this.fieldId = fieldId;
    this.$field = $('#'+accountId+'-field');
    // this.$spinner = this.$field.find('.spinner');
    // this.$spinner.removeClass('hidden');

    var data = {
      accountId: this.accountId,
      propertyId: this.propertyId,
      fieldId: this.fieldId
    };

    console.log(data);

    // Get Properties
    Craft.postActionRequest('analytics/getWebProperty', data, $.proxy(function(response, textStatus)
    {
      console.log(response);
      $.each(response, function (index, value) {
        console.log(value);
        $('#analytics-propertyId').append($('<option>', { 
            value: value.id,
            text : value.name 
        }));
      });

      $('#analytics-propertyId').val(this.propertyId);

    }, this));
    // ----------------------------------


    // ----------------------------------
    // Get All Web Properties
    // ----------------------------------
    $('#analyticsGetProperties').on('click', function(e){

      // Do something on click
      Craft.postActionRequest('analytics/getWebProperties', data, $.proxy(function(response, textStatus)
      {

        $.each(response, function (index, value) {
          console.log(value);
          $('#analytics-propertyId').append($('<option>', { 
              value: value.id,
              text : value.name 
          }));
        });

      }, that));
    });
    // ----------------------------------

  }
});

})(jQuery);