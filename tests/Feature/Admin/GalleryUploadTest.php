<?php

namespace Tests\Feature\Admin;

use App\Models\GalleryImage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class GalleryUploadTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_upload_gallery_image(): void
    {
        Storage::fake('public');
        $publicDisk = Storage::disk('public');

        $admin = $this->createAdminUser();

        $response = $this->actingAs($admin)->post(route('admin.gallery.store'), [
            'image' => UploadedFile::fake()->image('gallery-test.jpg', 1200, 800),
            'caption' => 'Foto uji upload',
            'sort_order' => 1,
            'is_active' => 1,
        ]);

        $response->assertRedirect(route('admin.gallery.index'));
        $this->assertDatabaseHas('gallery_images', [
            'caption' => 'Foto uji upload',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $gallery = GalleryImage::query()->where('caption', 'Foto uji upload')->firstOrFail();
        $this->assertTrue($publicDisk->exists($gallery->image_path));
    }

    public function test_admin_can_delete_gallery_image_and_file(): void
    {
        Storage::fake('public');
        $publicDisk = Storage::disk('public');

        $admin = $this->createAdminUser();

        $path = UploadedFile::fake()
            ->image('gallery-delete.jpg', 800, 600)
            ->store('gallery', 'public');

        $gallery = GalleryImage::query()->create([
            'image_path' => $path,
            'caption' => 'Foto untuk dihapus',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        $this->assertTrue($publicDisk->exists($path));

        $response = $this->actingAs($admin)->delete(route('admin.gallery.destroy', $gallery));

        $response->assertRedirect(route('admin.gallery.index'));
        $this->assertDatabaseMissing('gallery_images', [
            'id' => $gallery->id,
        ]);
        $this->assertFalse($publicDisk->exists($path));
    }

    private function createAdminUser(): User
    {
        /** @var User $admin */
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        return $admin;
    }
}
