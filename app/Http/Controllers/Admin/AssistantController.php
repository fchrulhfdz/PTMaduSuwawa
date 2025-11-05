<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class AssistantController extends Controller
{
    private $deepseekApiKey;
    private $deepseekBaseUrl = 'https://api.deepseek.com/v1';

    public function __construct()
    {
        $this->deepseekApiKey = env('DEEPSEEK_API_KEY');
    }

    /**
     * Display the AI Assistant interface
     */
    public function index()
    {
        return view('admin.assistant.index');
    }

    /**
     * Process chat message with DeepSeek AI
     */
    public function chat(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:2000',
            'conversation_id' => 'nullable|string'
        ]);

        try {
            if (!$this->deepseekApiKey) {
                return response()->json([
                    'success' => false,
                    'error' => 'API key tidak dikonfigurasi. Silakan hubungi administrator.'
                ], 500);
            }

            $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Bearer ' . $this->deepseekApiKey
            ])->timeout(60)->post($this->deepseekBaseUrl . '/chat/completions', [
                'model' => 'deepseek-chat',
                'messages' => [
                    [
                        'role' => 'system',
                        'content' => $this->getSystemPrompt()
                    ],
                    [
                        'role' => 'user',
                        'content' => $request->message
                    ]
                ],
                'stream' => false,
                'temperature' => 0.7,
                'max_tokens' => 2000
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                return response()->json([
                    'success' => true,
                    'response' => $data['choices'][0]['message']['content'],
                    'usage' => $data['usage'] ?? null,
                    'conversation_id' => $request->conversation_id ?? uniqid('conv_')
                ]);
            } else {
                Log::error('DeepSeek API Error: ' . $response->body());
                return response()->json([
                    'success' => false,
                    'error' => 'Terjadi kesalahan saat menghubungi AI Assistant: ' . $response->status()
                ], 500);
            }

        } catch (\Exception $e) {
            Log::error('Assistant Error: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'error' => 'Terjadi kesalahan internal: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get system prompt for the AI
     */
    private function getSystemPrompt()
    {
        return "Anda adalah AI Assistant khusus untuk sistem Manajemen Madu Suwawa. Anda membantu admin dalam mengelola:

1. PRODUK MADU:
   - Jenis madu: Madu Hutan, Madu Budidaya, Madu Organik, Madu Spesial
   - Manajemen stok, harga, dan kategori
   - Analisis penjualan produk

2. TRANSAKSI:
   - Proses penjualan kasir
   - Laporan keuangan
   - Manajemen pelanggan

3. TESTIMONI:
   - Kelola testimoni pelanggan
   - Filter testimoni aktif/featured

4. LAPORAN:
   - Analisis penjualan
   - Statistik produk terlaris
   - Insight bisnis madu

5. BISNIS MADU:
   - Tips penyimpanan madu
   - Manfaat kesehatan madu
   - Strategi pemasaran madu

Berikan jawaban yang:
- Singkat, jelas, dan langsung ke inti
- Fokus pada solusi praktis
- Sertakan tips yang dapat ditindaklanjuti
- Gunakan bahasa Indonesia yang formal namun mudah dipahami
- Berikan contoh konkret ketika diperlukan

Tanggapi pertanyaan dengan struktur yang rapi dan mudah dibaca.";
    }

    /**
     * Get chat history (optional - for future implementation)
     */
    public function getHistory()
    {
        // Untuk implementasi masa depan - menyimpan history chat
        return response()->json([
            'success' => true,
            'history' => []
        ]);
    }
}