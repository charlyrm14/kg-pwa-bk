<?php

namespace App\Console\Commands;

use Illuminate\Support\Str;
use App\Models\ContentType;
use App\Services\AI\PromptsContentBuilderService;
use App\Services\API\AIService;
use App\Services\Content\ContentManager;
use Illuminate\Console\Command;

class ContentGenerateAI extends Command
{
    public function __construct(
        protected ContentManager $manager,
        protected PromptsContentBuilderService $prompt,
        protected AIService $ai,
    ){
        parent::__construct();
    }

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'content:generate-ai {contentType}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generation of content such as news, sports tips, and nutrition';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $topic = ContentType::getBySlug($this->argument('contentType'));
    
        if(!$topic) {
            return $this->error("Tipo de contenido invalido, por favor ingresa un tipo de contenido valido");
        }

        if($topic->slug === 'events') {
            return $this->error("Tipo de contenido no soportado");
        }

        $this->info("Generando contenido de: {$topic->slug}");

        $systemInstructions = $this->prompt->instructions($topic);
        $prompt = $this->prompt->buildContentPrompt($topic);
            
        $payload = [
            [
                'role' => 'system', 
                'content' => $systemInstructions,
            ],
            [
                'role' => 'user', 
                'content' => $prompt
            ],
        ];

        $data = $this->ai->apiAI($payload);

        $newContent = array_merge($data, [
            'type' => $topic->slug,
            'content_type_id' => $topic->id, 
            'content_status_id' => 2, // Pending Review
            'author_id' => null
        ]);

        $content = $this->manager->handle($newContent);

        if(!$content) {
            return $this->error("Error al crear contenido {$topic->slug}");
        }

        $this->info("Contenido generado con éxito");
        $this->table([
            'ID', 
            'Name', 
            'Slug', 
            'Status'
        ], [
            [
                $content->id,
                $content->name,
                Str::limit($content->slug, 10, '...'),
                $content->status->name
            ]
        ]);
    }
}
