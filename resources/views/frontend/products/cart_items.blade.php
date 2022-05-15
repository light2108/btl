<?php use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
?>
<table class="table table-bordered">
    <thead>
        <tr>
            <th>Product</th>
            <th colspan="2">Description</th>
            <th>Quantity/Update</th>
            <th>Price</th>
            <th>Discount</th>

            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $total_price = 0;
        $discount_price = 0;
        $total_discount = 0;
        ?>
        @foreach ($userCartItems as $item)
            <?php $attrPrice = Product::getDiscountAttrPrice($item['product_id'], $item['size']); ?>

            <tr>
                <td> <img width="60" src="imgs/{{ $item['product']['main_image'] }}" alt="" /></td>
                <td colspan="2">
                    {{ $item['product']['product_name'] }}({{ $item['product']['product_code'] }})<br />Color
                    :
                    {{ $item['product']['product_color'] }}<br>Size : {{ $item['size'] }}</td>
                <td>
                    <div class="input-append">
                        <input class="span1" style="max-width:34px" value="{{ $item['quantity'] }}" placeholder="1"
                            id="appendedInputButtons" size="16" type="text">
                        <button class="btn btnItemUpdate qtyMinus" data-cartid="{{ $item['id'] }}" type="button"><i
                                class="icon-minus"></i></button>
                        <button class="btn btnItemUpdate qtyPlus" data-cartid="{{ $item['id'] }}" type="button"><i
                                class="icon-plus"></i></button>
                        <button class="btn btn-danger btnItemDelete" type="button" data-cartid="{{ $item['id'] }}"><i
                                class="icon-remove icon-white"></i></button>
                    </div>
                </td>
                <td>Rs.{{ $attrPrice['product_price'] }}.00</td>
                <td>Rs.{{ $attrPrice['discount'] }}.00</td>
                @if ($attrPrice['discounted_price'] > 0)
                    <td>Rs.{{ $attrPrice['discounted_price'] * $item['quantity'] }}.00</td>
                @else
                    <td>Rs.{{ $attrPrice['product_price'] * $item['quantity'] }}.00</td>
                @endif
            </tr>
            @if ($attrPrice['discounted_price'] > 0)
                <?php $total_price = $total_price + $attrPrice['discounted_price'] * $item['quantity'];
                ?>
            @else
                <?php $total_price = $total_price + $attrPrice['product_price'] * $item['quantity']; ?>
            @endif
            <?php $total_discount += $attrPrice['discount'] * $item['quantity']; ?>
        @endforeach
        <tr>
            <td colspan="6" style="text-align:right">Total Price: </td>
            <td> Rs.{{ $total_price }}.00</td>
        </tr>
        <tr>
            <td colspan="6" style="text-align:right">Coupon Discount: </td>
            <td class="couponAmount">

                @if(Session::has('couponAmount')&&User::countquantity()==0)
                    Rs.0.00
                @elseif (Session::has('couponAmount'))
                    Rs.{{ Session::get('couponAmount') }}.00
                @else Rs.0.00
                @endif
            </td>
        </tr>

        <tr>
            <td colspan="6" style="text-align:right"><strong>GRAND TOTAL
                    (Rs.{{ $total_price }}-<span class="couponAmount">
                    @if(Session::has('couponAmount')&&User::countquantity()==0)
                        Rs.0
                    @elseif (Session::has('couponAmount'))
                        Rs.{{ Session::get('couponAmount') }}.00
                        <?php Session::put('couponAmount',Session::get('couponAmount'));?>
                    @else Rs.0.00
                    @endif</span>)</span>

                    =</strong>
            </td>
            <td class="label label-important" style="display:block"> <strong class="grand_total">
                @if(User::countquantity()==0)
                Rs.0.00
                @else
                    Rs.{{$grand_total= $total_price - Session::get('couponAmount')}}.00
                    <?php Session::put('grand_total', $grand_total); ?>
                @endif
                </strong>
            </td>
        </tr>
    </tbody>
</table>
