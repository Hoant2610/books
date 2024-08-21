<?php

namespace App\Services;

use Exception;
use App\Models\Order;
use App\Models\Address;
use Illuminate\Support\Facades\DB;
use App\Repositories\BookRepository;
use App\Repositories\OrderRepository;
use App\Repositories\OrderDetailRepository;

class OrderService
{
    private OrderRepository $orderRepository;
    private OrderDetailRepository $orderDetailRepository;
    private BookRepository $bookRepository;
    public function __construct(OrderRepository $orderRepository, OrderDetailRepository $orderDetailRepository, BookRepository $bookRepository)
    {
        $this->orderRepository = $orderRepository;
        $this->orderDetailRepository = $orderDetailRepository;
        $this->bookRepository = $bookRepository;
    }
    public function createOrder($user, $address_id, $voucher_id, $shipment, $payment, $phone, $note, $items)
    {
        try {
            DB::beginTransaction();
            $address = Address::findOrFail($address_id);
            $address_detail = $address->toString();
            $order = $this->orderRepository->createOrder($user->id, $voucher_id, $address_detail, $phone, $note, $payment, $shipment);
            foreach ($items as $item) {
                $book_id = $item['book_id'];
                $book = $this->bookRepository->findById($book_id);
                $quantity = $item['quantity'];
                $orderDetail = $this->orderDetailRepository->createOrderDetail($book_id, $order->id, $quantity, $book->original_price, $book->sale_price);
            }
            DB::commit();
            // Xóa sp ra khỏi giỏ hàng
            foreach($items as $item){
                    // Lấy dữ liệu từ session
                    $cart = session()->get('cart', []);

                    // Lấy danh sách book_id cần xóa từ $items
                    $bookIdsToRemove = array_column($items, 'book_id');

                    // Lọc và loại bỏ các đối tượng với book_id nằm trong danh sách cần xóa
                    $cart = array_filter($cart, function ($bookCartDTO) use ($bookIdsToRemove) {
                        // Giả sử thuộc tính book của BookCartDTO có thuộc tính id
                        return !in_array($bookCartDTO->getBook()->id, $bookIdsToRemove);
                    });

                    // Cập nhật session với mảng đã được chỉnh sửa
                    session()->put('cart', $cart);
            }
            // Xóa session checkout
            session()->forget('items');
            return response()->json(['message' => 'successfully'], 200);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json(['error create order service' => $e->getMessage()]);
        }
    }

    public function getOrdersByUser($user){
        return $this->orderRepository->getOrdersByUserId($user->id);
    }
    public function getOrdersByUserIdAndStatus($user_id,$status){
        return $this->orderRepository->getOrdersByUserIdAndStatus($user_id,$status);
    }
}