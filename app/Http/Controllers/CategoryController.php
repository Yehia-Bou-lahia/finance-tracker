<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * عرض قائمة الفئات الخاصة بالمستخدم الحالي.
     */
    public function index()
    {
        // نجلب فقط فئات المستخدم الحالي (مبدأ العزل)
        $categories = Category::where('user_id', Auth::id())
            ->orderBy('name')
            ->paginate(10); // تقسيم النتائج إلى صفحات (10 فئات في الصفحة)

        return view('categories.index', compact('categories'));
    }

    /**
     * عرض صفحة إنشاء فئة جديدة.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * تخزين فئة جديدة في قاعدة البيانات.
     */
    public function store(StoreCategoryRequest $request)
    {
        // البيانات تم التحقق منها مسبقاً في StoreCategoryRequest
        $validated = $request->validated();
        
        // إضافة user_id تلقائياً من المستخدم الحالي
        $validated['user_id'] = Auth::id();
        
        Category::create($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'تمت إضافة الفئة بنجاح.');
    }

    /**
     * عرض تفاصيل فئة محددة (غير ضروري حالياً، لكننا نبقيه للمستقبل).
     */
    public function show(Category $category)
    {
        // التحقق من الصلاحية باستخدام Policy
        $this->authorize('view', $category);
        
        return view('categories.show', compact('category'));
    }

    /**
     * عرض صفحة تعديل فئة.
     */
    public function edit(Category $category)
    {
        $this->authorize('update', $category);
        
        return view('categories.edit', compact('category'));
    }

    /**
     * تحديث بيانات فئة في قاعدة البيانات.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $this->authorize('update', $category);
        
        $validated = $request->validated();
        
        $category->update($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'تم تحديث الفئة بنجاح.');
    }

    /**
     * حذف فئة من قاعدة البيانات.
     */
    public function destroy(Category $category)
    {
        $this->authorize('delete', $category);
        
        // التحقق من عدم وجود معاملات مرتبطة (القيد في DB سيمنع الحذف تلقائياً)
        // لكننا نضيف معالجة لطيفة للخطأ
        try {
            $category->delete();
            return redirect()
                ->route('categories.index')
                ->with('success', 'تم حذف الفئة بنجاح.');
        } catch (\Illuminate\Database\QueryException $e) {
            // إذا فشل الحذف بسبب معاملات مرتبطة (constraint restrict)
            return redirect()
                ->route('categories.index')
                ->with('error', 'لا يمكن حذف الفئة لأنها مرتبطة بمعاملات مالية.');
        }
    }
}