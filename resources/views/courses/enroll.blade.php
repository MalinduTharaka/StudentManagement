<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Make Payment for ' . $course->name) }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
                <form action="{{ route('courses.storePayment', $course->id) }}" method="POST" enctype="multipart/form-data" id="payment-form">
                    @csrf

                    <!-- Course Price and Discount -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Original Price:</label>
                        <p class="text-lg font-bold">{{ number_format($course->original_price, 2) }} {{ __('LKR') }}</p>

                        <label class="block text-gray-700 text-sm font-bold mb-2">Discounted Price:</label>
                        <p class="text-lg font-bold">{{ number_format($course->discount_price, 2) }} {{ __('LKR') }}</p>
                    </div>

                    <!-- Payment Option Selection -->
                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Select Payment Option</label>
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="payment_option" value="full_payment" onclick="togglePaymentFields('full_payment')" required>
                                <span class="ml-2">Full Payment</span>
                            </label>
                        </div>
                        <div>
                            <label class="inline-flex items-center">
                                <input type="checkbox" name="payment_option" value="installment" onclick="togglePaymentFields('installment')">
                                <span class="ml-2">Installment Payment</span>
                            </label>
                        </div>
                    </div>

                    <!-- Full Payment Section -->
                    <div id="full-payment-section" class="hidden">
                        <p class="mb-2 text-lg font-bold">Total Payment: {{ number_format($course->original_price-$course->discount_price, 2) }} {{ __('LKR') }}</p>

                        <!-- Payment Method Selection -->
                        <div class="mb-4">
                            <label class="block text-gray-700 text-sm font-bold mb-2">Select Payment Method</label>
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="payment_method" value="card" onclick="togglePaymentMethods('card')">
                                    <span class="ml-2">Card Payment</span>
                                </label>
                            </div>
                            <div>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="payment_method" value="bank_draft" onclick="togglePaymentMethods('bank_draft')">
                                    <span class="ml-2">Bank Draft</span>
                                </label>
                            </div>
                        </div>

                        <!-- Card Payment Fields -->
                        <div id="card-payment-fields" class="hidden">
                            <div class="mb-4">
                                <a href="/card-payment-page" class="btn btn-primary">Pay Now</a>
                            </div>
                        </div>

                        <!-- Bank Draft Fields -->
                        <div id="bank-draft-fields" class="hidden">
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Upload Bank Payment Slip</label>
                                <input type="file" name="payment_slip" class="form-input w-full" accept="image/*" required>
                            </div>
                            <div class="mb-4">
                                <button type="submit" class="btn btn-primary">Submit Payment</button>
                            </div>
                        </div>
                    </div>

                    <!-- Installment Payment Section -->
                    <div id="installment-payment-section" class="hidden">
                        @if ($course->installment_count > 0)
                            <p class="mb-2 text-lg font-bold">
                                Installment Amount: {{ number_format($course->discount_price / $course->installment_count, 2) }} {{ __('LKR') }} per installment
                            </p>

                            <!-- Payment Method for Installments -->
                            <div class="mb-4">
                                <label class="block text-gray-700 text-sm font-bold mb-2">Select Payment Method</label>
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="installment_payment_method" value="card" onclick="toggleInstallmentFields('card')">
                                        <span class="ml-2">Card Payment</span>
                                    </label>
                                </div>
                                <div>
                                    <label class="inline-flex items-center">
                                        <input type="radio" name="installment_payment_method" value="bank_draft" onclick="toggleInstallmentFields('bank_draft')">
                                        <span class="ml-2">Bank Draft</span>
                                    </label>
                                </div>
                            </div>

                            <!-- Card Payment Fields for Installment -->
                            <div id="installment-card-fields" class="hidden">
                                <div class="mb-4">
                                    <a href="/installment-card-payment-page" class="btn btn-primary">Pay Now</a>
                                </div>
                            </div>

                            <!-- Bank Draft Fields for Installment -->
                            <div id="installment-bank-draft-fields" class="hidden">
                                <div class="mb-4">
                                    <label class="block text-gray-700 text-sm font-bold mb-2">Upload Bank Payment Slip</label>
                                    <input type="file" name="installment_payment_slip" class="form-input w-full" accept="image/*">
                                </div>
                                <div class="mb-4">
                                    <button type="submit" class="btn btn-primary">Submit Payment</button>
                                </div>
                            </div>
                        @else
                            <p class="mb-2 text-lg font-bold text-red-600">Installment options are not available for this course.</p>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function togglePaymentFields(option) {
            const fullPaymentSection = document.getElementById('full-payment-section');
            const installmentPaymentSection = document.getElementById('installment-payment-section');

           // Show/Hide sections based on payment selection
           if (option === 'full_payment') {
                fullPaymentSection.style.display = fullPaymentSection.style.display === 'block' ? 'none' : 'block';
                if (fullPaymentSection.style.display === 'none') {
                    // Hide associated fields if full payment section is hidden
                    togglePaymentMethods('card'); // Hide card payment fields
                    togglePaymentMethods('bank_draft'); // Hide bank draft fields
                }
                installmentPaymentSection.style.display = 'none'; // Hide installment section if full payment is selected
            } else if (option === 'installment') {
                installmentPaymentSection.style.display = installmentPaymentSection.style.display === 'block' ? 'none' : 'block';
                if (installmentPaymentSection.style.display === 'none') {
                    // Hide associated fields if installment section is hidden
                    toggleInstallmentFields('card'); // Hide card payment fields
                    toggleInstallmentFields('bank_draft'); // Hide bank draft fields
                }
                fullPaymentSection.style.display = 'none'; // Hide full payment section if installment is selected
            }

        }

        function togglePaymentMethods(method) {
            const cardFields = document.getElementById('card-payment-fields');
            const bankDraftFields = document.getElementById('bank-draft-fields');

            cardFields.style.display = document.querySelector('input[name="payment_method"][value="card"]').checked ? 'block' : 'none';
            bankDraftFields.style.display = document.querySelector('input[name="payment_method"][value="bank_draft"]').checked ? 'block' : 'none';
        }

        function toggleInstallmentFields(method) {
            const installmentCardFields = document.getElementById('installment-card-fields');
            const installmentBankDraftFields = document.getElementById('installment-bank-draft-fields');

            installmentCardFields.style.display = document.querySelector('input[name="installment_payment_method"][value="card"]').checked ? 'block' : 'none';
            installmentBankDraftFields.style.display = document.querySelector('input[name="installment_payment_method"][value="bank_draft"]').checked ? 'block' : 'none';
        }
    </script>
</x-app-layout>
