@extends('layouts.main')

@section('content')
<div class="profile-container py-5">
    <div class="container">
        <div class="row">
            <!-- العمود الجانبي -->
            <div class="col-lg-4 mb-4">
                <div class="card profile-sidebar shadow-sm">
                    <div class="card-body text-center">
                        <!-- صورة البروفايل -->
                        <div class="profile-avatar-container mb-3">
                            <img src="{{ Auth::user()->avatar_url ?? 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->name).'&background=random' }}" 
                                 class="profile-avatar rounded-circle" 
                                 alt="صورة المستخدم">
                            <button class="btn btn-sm btn-primary avatar-upload-btn" data-bs-toggle="modal" data-bs-target="#avatarModal">
                                <i class="fas fa-camera"></i>
                            </button>
                        </div>
                        
                        <h4 class="profile-name">{{ Auth::user()->name }}</h4>
                        <p class="text-muted mb-3">{{ Auth::user()->email }}</p>
                        
                        <!-- إحصائيات المستخدم -->
                        <div class="user-stats d-flex justify-content-around mb-3">
                            <div class="stat-item">
                                <div class="stat-number">{{ $borrowedBooksCount }}</div>
                                <div class="stat-label">كتب مستعارة</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">{{ $returnedBooksCount }}</div>
                                <div class="stat-label">كتب مسترجعة</div>
                            </div>
                        </div>
                        
                        <!-- عضوية منذ -->
                        <div class="membership-since">
                            <i class="fas fa-calendar-alt me-2"></i>
                            عضو منذ {{ Auth::user()->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- المحتوى الرئيسي -->
            <div class="col-lg-8">
                <div class="card profile-content shadow-sm">
                    <div class="card-header bg-white">
                        <ul class="nav nav-tabs card-header-tabs" id="profileTabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">
                                    <i class="fas fa-user-circle me-2"></i> المعلومات الشخصية
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="books-tab" data-bs-toggle="tab" data-bs-target="#books" type="button" role="tab">
                                    <i class="fas fa-book me-2"></i> الكتب المستعارة
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="settings-tab" data-bs-toggle="tab" data-bs-target="#settings" type="button" role="tab">
                                    <i class="fas fa-cog me-2"></i> الإعدادات
                                </button>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="card-body">
                        <div class="tab-content" id="profileTabsContent">
                            <!-- تبويب المعلومات الشخصية -->
                            <div class="tab-pane fade show active" id="info" role="tabpanel">
                                <form action="{{ route('profile.update') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="name" class="form-label">الاسم الكامل</label>
                                            <input type="text" class="form-control" id="name" name="name" 
                                                   value="{{ old('name', Auth::user()->name) }}" required>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="email" class="form-label">البريد الإلكتروني</label>
                                            <input type="email" class="form-control" id="email" name="email" 
                                                   value="{{ old('email', Auth::user()->email) }}" required>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="phone" class="form-label">رقم الهاتف</label>
                                            <input type="tel" class="form-control" id="phone" name="phone" 
                                                   value="{{ old('phone', Auth::user()->phone) }}">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="address" class="form-label">العنوان</label>
                                            <input type="text" class="form-control" id="address" name="address" 
                                                   value="{{ old('address', Auth::user()->address) }}">
                                        </div>
                                    </div>
                                    
                                    <div class="mb-3">
                                        <label for="bio" class="form-label">نبذة عني</label>
                                        <textarea class="form-control" id="bio" name="bio" rows="3">{{ old('bio', Auth::user()->bio) }}</textarea>
                                    </div>
                                    
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i> حفظ التغييرات
                                    </button>
                                </form>
                            </div>
                            
                            <!-- تبويب الكتب المستعارة -->
                            <div class="tab-pane fade" id="books" role="tabpanel">
                                @if($borrowedBooks->isEmpty())
                                    <div class="text-center py-4">
                                        <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
                                        <h5 class="text-muted">لا توجد كتب مستعارة حالياً</h5>
                                        <a href="{{ route('home') }}" class="btn btn-primary mt-2">
                                            <i class="fas fa-book me-2"></i> تصفح الكتب
                                        </a>
                                    </div>
                                @else
                                    <div class="table-responsive">
                                        <table class="table table-hover">
                                            <thead>
                                                <tr>
                                                    <th>الكتاب</th>
                                                    <th>تاريخ الاستعارة</th>
                                                    <th>تاريخ الاستحقاق</th>
                                                    <th>الحالة</th>
                                                    <th>إجراءات</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($borrowedBooks as $borrow)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex align-items-center">
                                                            <img src="{{ $borrow->book->cover_image ?? asset('images/default-book.png') }}" 
                                                                 class="book-cover me-3" alt="غلاف الكتاب">
                                                            <div>
                                                                <h6 class="mb-0">{{ $borrow->book->title }}</h6>
                                                                <small class="text-muted">{{ $borrow->book->author }}</small>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{ $borrow->borrow_date->format('Y/m/d') }}</td>
                                                    <td>{{ $borrow->due_date->format('Y/m/d') }}</td>
                                                    <td>
                                                        @if($borrow->return_date)
                                                            <span class="badge bg-success">تم الإرجاع</span>
                                                        @elseif($borrow->due_date->isPast())
                                                            <span class="badge bg-danger">متأخر</span>
                                                        @else
                                                            <span class="badge bg-primary">مستعار</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if(!$borrow->return_date)
                                                        <form action="{{ route('borrows.return', $borrow->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            <button type="submit" class="btn btn-sm btn-outline-primary">
                                                                إرجاع الكتاب
                                                            </button>
                                                        </form>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    
                                    {{ $borrowedBooks->links() }}
                                @endif
                            </div>
                            
                            <!-- تبويب الإعدادات -->
                            <div class="tab-pane fade" id="settings" role="tabpanel">
                                <div class="mb-4">
                                    <h5 class="mb-3">تغيير كلمة المرور</h5>
                                    <form action="{{ route('profile.password') }}" method="POST">
                                        @csrf
                                        
                                        <div class="mb-3">
                                            <label for="current_password" class="form-label">كلمة المرور الحالية</label>
                                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="new_password" class="form-label">كلمة المرور الجديدة</label>
                                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                                        </div>
                                        
                                        <div class="mb-3">
                                            <label for="new_password_confirmation" class="form-label">تأكيد كلمة المرور الجديدة</label>
                                            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
                                        </div>
                                        
                                        <button type="submit" class="btn btn-primary">
                                            <i class="fas fa-key me-2"></i> تغيير كلمة المرور
                                        </button>
                                    </form>
                                </div>
                                
                                <div class="border-top pt-4">
                                    <h5 class="mb-3">إعدادات الحساب</h5>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="emailNotifications" checked>
                                        <label class="form-check-label" for="emailNotifications">تلقي إشعارات البريد الإلكتروني</label>
                                    </div>
                                    
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <h6 class="mb-1">حذف الحساب</h6>
                                            <p class="small text-muted mb-0">بمجرد حذف حسابك، لا يمكن استرجاعه مرة أخرى.</p>
                                        </div>
                                        <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                                            <i class="fas fa-trash-alt me-2"></i> حذف الحساب
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal تغيير صورة البروفايل -->
<div class="modal fade" id="avatarModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تغيير صورة البروفايل</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('profile.avatar') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="avatar" class="form-label">اختر صورة</label>
                        <input class="form-control" type="file" id="avatar" name="avatar" accept="image/*">
                    </div>
                    <div class="text-center">
                        <img id="avatarPreview" src="#" alt="Preview" class="img-thumbnail d-none" style="max-height: 200px;">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ الصورة</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal حذف الحساب -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title text-danger">تأكيد حذف الحساب</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('profile.destroy') }}" method="POST">
                @csrf
                @method('DELETE')
                <div class="modal-body">
                    <p>هل أنت متأكد أنك تريد حذف حسابك؟ جميع بياناتك سيتم حذفها بشكل دائم.</p>
                    <div class="mb-3">
                        <label for="deletePassword" class="form-label">أدخل كلمة المرور للتأكيد</label>
                        <input type="password" class="form-control" id="deletePassword" name="password" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-danger">حذف الحساب</button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
.profile-container {
    background-color: #f8f9fa;
    min-height: calc(100vh - 72px);
}

.profile-sidebar {
    position: sticky;
    top: 20px;
    border: none;
    border-radius: 10px;
}

.profile-avatar-container {
    position: relative;
    width: fit-content;
    margin: 0 auto;
}

.profile-avatar {
    width: 150px;
    height: 150px;
    object-fit: cover;
    border: 3px solid #fff;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.avatar-upload-btn {
    position: absolute;
    bottom: 10px;
    right: 10px;
    width: 36px;
    height: 36px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
}

.profile-name {
    font-weight: 600;
    margin-bottom: 5px;
}

.user-stats {
    border-top: 1px solid #eee;
    border-bottom: 1px solid #eee;
    padding: 15px 0;
}

.stat-item {
    text-align: center;
}

.stat-number {
    font-size: 1.5rem;
    font-weight: 700;
    color: var(--primary-color);
}

.stat-label {
    font-size: 0.8rem;
    color: #6c757d;
}

.membership-since {
    font-size: 0.9rem;
    color: #6c757d;
}

.profile-content {
    border: none;
    border-radius: 10px;
}

.book-cover {
    width: 50px;
    height: 70px;
    object-fit: cover;
    border-radius: 4px;
}

.nav-tabs .nav-link {
    border: none;
    color: #6c757d;
    font-weight: 500;
    padding: 0.75rem 1.25rem;
}

.nav-tabs .nav-link.active {
    color: var(--primary-color);
    border-bottom: 3px solid var(--primary-color);
    background-color: transparent;
}

.tab-content {
    padding: 20px 0;
}

@media (max-width: 991.98px) {
    .profile-sidebar {
        position: static;
        margin-bottom: 20px;
    }
    
    .profile-avatar {
        width: 120px;
        height: 120px;
    }
}
</style>
@endpush

@push('scripts')
<script>
// عرض معاينة الصورة قبل رفعها
document.getElementById('avatar').addEventListener('change', function(event) {
    const preview = document.getElementById('avatarPreview');
    const file = event.target.files[0];
    
    if (file) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.classList.remove('d-none');
        }
        
        reader.readAsDataURL(file);
    }
});

// التحقق من صحة كلمة المرور عند حذف الحساب
document.getElementById('deleteAccountModal').addEventListener('shown.bs.modal', function() {
    document.getElementById('deletePassword').focus();
});
</script>
@endpush