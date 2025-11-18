<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;

class RegisterValidationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * @dataProvider invalidRegisterData
     */
    public function 登録フォームのバリデーションチェック($field, $value, $message)
    {
        // ① 正常データ
        $validData = [
            'name' => 'テストユーザー',
            'email' => 'dummy@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        // ② テスト対象項目だけ上書き
        $formData = array_merge($validData, [$field => $value]);

        // ③ POST送信
        $response = $this->post(('/register'), $formData);

        // ④ 指定のフィールドにエラーが出ること
        $response->assertSessionHasErrors([
            $field => $message,
        ]);

        // ⑤ DB登録なし
        $this->assertDatabaseCount('users', 0);
    }

    /**
     * バリデーションデータセット
     */
    public static function invalidRegisterData(): array
    {
        return [
            '名前が空' => [
                'name',
                '',
                'お名前を入力してください',
            ],

            'メールが空' => [
                'email',
                '',
                'メールアドレスを入力してください',
            ],

            'メール形式不正' => [
                'email',
                'invalid-email',
                'メールアドレスはメール形式で入力してください',
            ],

            'パスワード未入力' => [
                'password',
                '',
                'パスワードを入力してください',
            ],

            'パスワードが8文字未満' => [
                'password',
                '1234567',
                'パスワードは8文字以上で入力してください',
            ],

            '確認用パスワード不一致' => [
                'password',
                'wrongpassword',
                'パスワードと一致しません',
            ],
        ];
    }

    /**
     * @test
     */
    public function 全ての項目が正しく入力されている場合はメール認証画面にリダイレクトされる()
    {
        $formData = [
            'name' => 'テストユーザー',
            'email' => 'dummy@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        // ① 登録実行
        $response = $this->post(('/register'), $formData);


        // ② DB登録確認
        $this->assertDatabaseHas('users', [
            'email' => 'dummy@example.com',
            'email_verified_at' => null, // ← まだ未認証
        ]);

        // ③ Fortify標準：メール認証ページにリダイレクト
        $response->assertRedirect('/email/verify');

        // ④ 自動ログインされていること（Fortify仕様）
        $this->assertAuthenticated();

        // ⑤ 認証はまだ完了していない
        $this->assertNull(auth()->user()->email_verified_at);
    }

    /**
     * @test
     */
    public function 認証済みユーザーはプロフィール設定画面にアクセスできる()
    {
        // ① 認証済みユーザー作成
        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        // ② ログイン状態でプロフィール設定画面を開く
        $response = $this->actingAs($user)
                        ->get('/profile/create');

        // ③ 正常表示
        $response->assertStatus(200);
    }

    /**
     * @test
     */
    public function 未認証ユーザーはプロフィール設定画面にアクセスできず認証画面へリダイレクトされる()
    {
        // ① 未認証ユーザー作成
        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        // ② ログイン状態でプロフィール設定ページを開く
        $response = $this->actingAs($user)
                        ->get('/profile/create');
        dd($response->status(), $response->headers->get('Location'));

        // ③ Fortify仕様：認証画面へリダイレクト
        $response->assertRedirect('/email/verify');
    }
}

