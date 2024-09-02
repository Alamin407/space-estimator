jQuery(document).ready(function($) {
    // Automatically load estimates when the page is loaded
    function loadEstimates() {
        $.ajax({
            url: spaceEstimatorAjax.ajax_url,
            type: 'POST',
            data: {
                action: 'load_estimates'
            },
            success: function(response) {
                $('.se-content-box').html(response);
                updateTotalVolume();
                checkCalculateVisibility(); // Initial check
                updateTextarea(); // Initial textarea update
            },
            error: function() {
                $('.se-content-box').html('<p>There was an error loading the estimates. Please try again.</p>');
            }
        });
    }

    // Update total volume calculation
    function updateTotalVolume() {
        let totalVolume = 0;
        $('.se-item-list').each(function() {
            $(this).find('.item-total').each(function() {
                totalVolume += parseFloat($(this).text()) || 0;
            });
        });
        $('#total-volume').html(totalVolume.toFixed(2) + 'm<sup>3</sup>');
    }

    // Clone select box options from existing room
    function cloneSelectOptions() {
        const options = $('.se-items-wrap:first .space-estimator-select').html();
        return options;
    }

    // Handle Add Room button click
    $(document).on('click', '.se-add-btn', function() {
        let roomName = $('.sp-data').val();
        if (roomName) {
            let selectOptions = cloneSelectOptions(); // Clone options from the first room
            $('.se-content-box').append(`
                <div class="se-items-wrap my-4" data-room="${roomName}">
                    <div class="se-item-content">
                        <div class="se-item-content-header">
                            <div class="se-head-left">
                                <h3 class="room-name">${roomName}</h3>
                            </div>
                            <div class="se-head-right">
                                <h3 class="room-total" id="total">0.00<sup>3</sup></h3>
                            </div>
                        </div>
                        <div class="se-item-content-body">
                            <div class="item"><h3>Item</h3></div>
                            <div class="volume"><h3>Volume</h3></div>
                            <div class="quantity"><h3>Quantity</h3></div>
                            <div class="total"><h3>Total</h3></div>
                        </div>
                        <ul class="se-item-list" id="item-list"></ul>
                        <select name="space_estimator_items" class="space-estimator-select form-select">
                            ${selectOptions} <!-- Use cloned options -->
                        </select>
                    </div>
                </div>
            `);
            checkCalculateVisibility(); // Check visibility when a new room is added
            updateTextarea(); // Update textarea when a new room is added
            $('.sp-data').val('');
        }
    });

    // Handle item selection from the select box
    $(document).on('change', '.space-estimator-select', function() {
        let selectedItem = $(this).find('option:selected');
        let roomWrapper = $(this).closest('.se-items-wrap');
        $(this).addClass('mt-3');

        // Check if the item has already been added
        if (roomWrapper.find(`#item-list .item-name:contains(${selectedItem.data('item')})`).length === 0) {
            let itemData = {
                item: selectedItem.data('item'),
                volume: selectedItem.data('volume'),
                quantity: 1, // Default quantity
                total: selectedItem.data('total')
            };

            // Update the DOM with selected item data
            let itemList = roomWrapper.find('#item-list');
            itemList.append(`
                <li class="se-item">
                    <div class="item-name">${itemData.item}</div>
                    <div class="item-volume">${itemData.volume}m<sup>3</sup></div>
                    <div class="item-quantity"><input type="number" value="${itemData.quantity}" class="quantity-input"></div>
                    <div class="item-total">${itemData.total}m<sup>3</sup></div>
                </li>
            `);

            // Update the room total
            updateRoomTotal(roomWrapper);

            // Recalculate the total volume for all rooms
            updateTotalVolume();

            // Show the calculate section
            $('.se-calculate').show();
            updateTextarea(); // Update textarea on item selection
        }

        // Check if the calculate section should be visible
        checkCalculateVisibility();
    });

    // Handle quantity change
    $(document).on('input', '.quantity-input', function() {
        let quantity = parseFloat($(this).val()) || 0;
        let itemRow = $(this).closest('.se-item');
        let itemVolume = parseFloat(itemRow.find('.item-volume').text()) || 0;
        let newTotal = quantity * itemVolume;

        // Update total for this item
        itemRow.find('.item-total').text(newTotal.toFixed(2));

        // Update the room total
        let roomWrapper = $(this).closest('.se-items-wrap');
        updateRoomTotal(roomWrapper);

        // Recalculate the total volume for all rooms
        updateTotalVolume();

        // Update textarea
        updateTextarea();
    });

    // Update the total for a specific room
    function updateRoomTotal(roomWrapper) {
        let roomTotal = 0;
        roomWrapper.find('#item-list .item-total').each(function() {
            roomTotal += parseFloat($(this).text()) || 0;
        });
        roomWrapper.find('.room-total').html(roomTotal.toFixed(2) + 'm<sup>3</sup>');
    }

    // Check visibility of the calculate section
    function checkCalculateVisibility() {
        let anyItemsAdded = false;
        $('.se-item-list').each(function() {
            if ($(this).find('.se-item').length > 0) {
                anyItemsAdded = true;
            }
        });
        if (anyItemsAdded) {
            $('.se-calculate').show();
        } else {
            $('.se-calculate').hide();
        }
    }

    // Update textarea with room data
    function updateTextarea() {
        let textareaContent = '';

        $('.se-items-wrap').each(function() {
            let roomName = $(this).find('.room-name').text();
            let roomTotal = $(this).find('.room-total').text();
            textareaContent += `${roomName}: ${roomTotal}\n`;
            textareaContent += '--------------------------\n';

            $(this).find('#item-list .se-item').each(function() {
                let item = $(this).find('.item-name').text().trim();
                let volume = $(this).find('.item-volume').text().trim();
                let quantity = $(this).find('.item-quantity input').val().trim();
                let total = $(this).find('.item-total').text().trim();

                textareaContent += `Item: ${item}\n`;
                textareaContent += `Volume: ${volume}\n`;
                textareaContent += `Quantity: ${quantity}\n`;
                textareaContent += `Total: ${total}\n`;
                textareaContent += '\n'; // Add a newline for separation
            });

            textareaContent += '\n'; // Add a newline between rooms
        });

        $('#estimates-textarea').val(textareaContent.trim());
    }

    // Load estimates on page load
    loadEstimates();
});
