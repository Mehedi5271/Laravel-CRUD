<x-master>
    <x-slot:title>
        E-Shop | Cart Products
    </x-slot>
  
    <table class="table table-striped" >
        <thead>
            <th></th>
            <th>Serial</th>
            <th>Product</th>
            <th>Quantity</th>
            <th class="text-center">Price</th>
        </thead>
        <tbody>
            @foreach (auth()->user()->cartProducts as $cartProduct)
                
            <tr>
                <td><span class="btn  btn-sm btn-danger me-2 remove-btn" data-id="{{$cartProduct->id}}">x</span></td>
                <td>  {{$loop->iteration}} </td>
                <td>{{$cartProduct->product->title}} {{$cartProduct->color ? '-'.$cartProduct->color->name:null}} </td>
                <td > {{$cartProduct->quantity}} </td>
                <td class="price text-end"> {{$cartProduct->quantity*$cartProduct->product->price}} </td>
            </tr>
        </tbody>
        @endforeach
        <tr>
            <td colspan="4"></td>
            <td class="text-end">Total: <span id="total_price">0</span></td>
        </tr>
    </table>
   @push('script')
   <script>
    const removeBtn = document.querySelectorAll('.remove-btn');
    removeBtn.forEach(function(btn){
        btn.addEventListener('click', function(){

            const id =btn.getAttribute('data-id');

            fetch('/cart-products/'+id, {
            method: 'DELETE',
            
            headers: {
                     'X-CSRF-TOKEN': '{{csrf_token()}}'
                      }

                 })
                 .then(res => res.json()) 
                 .then(data=>{
                    if(data.success==true){
                        btn.parentElement.parentElement.remove();
                        updateTotalPrice();
                        alert(data.message)
                    } else{
                        alert('somethings went wrong') 
                    }

                    })
            .catch(err => console.log(err));

           
        })            
    }) 
    updateTotalPrice()
   function updateTotalPrice()
   {
    const priceElement = document.querySelectorAll('.price');
    let totalPrice = 0; 
    priceElement.forEach(function(element){
        totalPrice += parseFloat(element.innerText);
      document.getElementById('total_price').innerText=totalPrice
    }) 
   }  

     </script>
       
   @endpush
</x-master>