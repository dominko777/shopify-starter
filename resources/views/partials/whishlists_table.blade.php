<table class="mx-4 py-2 table-auto">
  <thead>
    <tr>
      <th class="px-4 py-2">Id</th>
      <th class="px-4 py-2">Name</th>
    </tr>
  </thead>
  <tbody>
  	@foreach($products['body']->container['data']['nodes'] as $product)
    <tr>
      <td class="border px-4 py-2">{{ $product['id'] }}</td>
      <td class="border px-4 py-2">{{ $product['title'] }}</td>
    </tr>
    @endforeach
  </tbody>
</table>
