<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CandidateResource\Pages;
use App\Models\Candidate;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class CandidateResource extends Resource
{
    protected static ?string $model = Candidate::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Name')
                    ->required()
                    ->maxLength(255),

                FileUpload::make('image_url')
                    ->label('Upload Image(s)')
                    ->image()
                    ->disk('public')  // Ensure it uses the public disk
                    ->directory('api') // Save it in the api folder
                    ->required()  // Make sure the file is required
            ]);
    }


    public static function table(Table $table): Table
    {


        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->alignLeft(),
                ImageColumn::make('image_url')
                    ->label('Image')
                    ->rounded()
                    ->sortable(),


            ])
            ->filters([
                // Add filters if needed
            ])
            ->actions([
//                Tables\Actions\ViewAction::make(),
//                Tables\Actions\EditAction::make(),
//                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make()
                        ->action(function ($records) {
                            // Tanlangan yozuvlar haqida log
                            Log::info('Bulk o\'chirish amali boshlanishi. Tanlangan yozuvlar:', ['tanlangan_yozuvlar' => $records]);

                            // $records Eloquent kolleksiyasi ekanligini ta\'minlash
                            // Kandidat IDlarini olish
                            $candidateIds = $records->pluck('id')->toArray();

                            // O\'chirish uchun IDlarni logga yozish
                            Log::info('O\'chirilishi kerak bo\'lgan kandidat IDlari:', ['kandidat_idlari' => $candidateIds]);

                            // API sorovi yuborish
                            try {
                                // API'ga yuboriladigan so'rovni logga yozish
                                Log::info('API so\'rovi yuborilmoqda. Yuborilayotgan ma\'lumotlar:', [
                                    'url' => 'http://facesec.newuu.uz/api/candidates/delete/',
                                    'candidate_ids' => $candidateIds
                                ]);

                                $response = Http::post('http://facesec.newuu.uz/api/candidates/delete/', [
                                    'candidate_ids' => $candidateIds,
                                ]);

                                // API javobini logga yozish
                                Log::info('API javobi olindi.', ['status' => $response->status()]);

                                if ($response->successful()) {
                                    // Muvaffaqiyatli o\'chirish
                                    Log::info('API orqali o\'chirish muvaffaqiyatli bo\'ldi, mahalliy yozuvlarni o\'chirishga o\'tilmoqda.');

                                    foreach ($records as $record) {
                                        // Har bir o\'chirilgan yozuvni logga yozish
                                        Log::info('Yozuv o\'chirilmoqda.', ['record_id' => $record->id]);
                                        $record->delete(); // Yozuvni o'chirish
                                    }

                                    // O\'chirish amali muvaffaqiyatli yakunlandi
                                    Log::info('Barcha yozuvlar muvaffaqiyatli o\'chirildi.');
                                } else {
                                    // API o\'chirishda xatolik yuz berdi
                                    Log::error('API orqali o\'chirishda xatolik yuz berdi.', ['status' => $response->status()]);
                                    return back()->withErrors(['msg' => 'API o\'chirishda xatolik yuz berdi']);
                                }
                            } catch (\Exception $e) {
                                // API so'rovi paytida xatolik yuz berdi
                                Log::error('API so\'rovi yuborishda xatolik yuz berdi.', [
                                    'exception' => $e->getMessage(),
                                ]);
                                return back()->withErrors(['msg' => 'Xatolik yuz berdi: ' . $e->getMessage()]);
                            }

                            // O\'chirish amali tugagandan so\'ng sahifaga qaytish
                            Log::info('O\'chirish amali tugadi, bosh sahifaga qaytish.');

                        })
                ])
            ]
            );


    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageCandidates::route('/'),
        ];
    }

}




