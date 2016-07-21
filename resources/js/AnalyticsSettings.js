
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
$(document).ready(function() {
  var spinner;
  console.log('DATA', data);
  spinner = $('.spinner');
  if (data.accountId) {
    spinner.removeClass('hidden');
    Craft.postActionRequest('analytics/getWebProperty', data, $.proxy((function(response, textStatus) {
      $.each(response, function(index, value) {
        var checked, html;
        console.log(value);
        checked = data.propertyId === value.id;
        if (checked) {
          html = '<div class="account-toggle"><input type="radio" name="property" value="' + value.id + '" checked><div class="cover"><label>' + value.name + '</label></div></div>';
        } else {
          html = '<div class="account-toggle"><input type="radio" name="property" value="' + value.id + '"><div class="cover"><label>' + value.name + '</label></div></div>';
        }
        $('.property-toggles').append(html);
        spinner.addClass('hidden');
      });
    }), this));
  }
  $('input[type=radio][name=account]').on('change', function(e) {
    var newData;
    console.log(this.value);
    $('.property-toggles').html('');
    spinner.removeClass('hidden');
    newData = {
      accountId: this.value
    };
    return Craft.postActionRequest('analytics/getWebProperties', newData, $.proxy((function(response, textStatus) {
      $.each(response, function(index, value) {
        var checked, html;
        console.log(value);
        checked = data.propertyId === value.id;
        if (checked) {
          html = '<div class="account-toggle"><input type="radio" name="property" value="' + value.id + '" checked><div class="cover"><label>' + value.name + '</label></div></div>';
        } else {
          html = '<div class="account-toggle"><input type="radio" name="property" value="' + value.id + '"><div class="cover"><label>' + value.name + '</label></div></div>';
        }
        $('.property-toggles').append(html);
        spinner.addClass('hidden');
      });
    }), this));
  });
});
