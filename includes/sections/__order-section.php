    <!-- Order Section -->
    <section id="order" class="order-section">
        <div class="container">
            <h2 class="text-center mb-5" data-aos="fade-up">অর্ডার করুন</h2>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="order-form">
                        <form id="orderForm">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="text" class="form-control" id="name" placeholder="আপনার নাম" required>
                                        <label for="name">আপনার নাম *</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="tel" class="form-control" id="phone" placeholder="মোবাইল নাম্বার" required>
                                        <label for="phone">মোবাইল নাম্বার *</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating">
                                        <textarea class="form-control" id="address" placeholder="ঠিকানা" style="height: 100px" required></textarea>
                                        <label for="address">ঠিকানা *</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" id="quantity" required>
                                            <option value="">পরিমাণ নির্বাচন করুন</option>
                                            <option value="250">২৫০ গ্রাম - ৪৫০ টাকা</option>
                                            <option value="500">৫০০ গ্রাম - ৮৫০ টাকা</option>
                                            <option value="1000">১ কেজি - ১৬৫০ টাকা</option>
                                        </select>
                                        <label for="quantity">পরিমাণ *</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <select class="form-select" id="payment" required>
                                            <option value="">পেমেন্ট মেথড নির্বাচন করুন</option>
                                            <option value="cod">ক্যাশ অন ডেলিভারি</option>
                                            <option value="bkash">বিকাশ</option>
                                            <option value="nagad">নগদ</option>
                                            <option value="rocket">রকেট</option>
                                        </select>
                                        <label for="payment">পেমেন্ট মেথড *</label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="order-summary">
                                        <h4>অর্ডার সামারি</h4>
                                        <div class="summary-item">
                                            <span>পরিমাণ:</span>
                                            <span id="summaryQuantity">-</span>
                                        </div>
                                        <div class="summary-item">
                                            <span>মূল্য:</span>
                                            <span id="summaryPrice">-</span>
                                        </div>
                                        <div class="summary-item">
                                            <span>ডেলিভারি চার্জ:</span>
                                            <span>ফ্রি</span>
                                        </div>
                                        <div class="summary-item total">
                                            <span>সর্বমোট:</span>
                                            <span id="summaryTotal">-</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12 text-center">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-shopping-cart me-2"></i>
                                        অর্ডার কনফার্ম করুন
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>