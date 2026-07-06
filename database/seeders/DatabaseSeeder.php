<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $user = User::firstOrCreate(
            ['email' => "admin@blog.local"],
            [
                'name' => 'Hiago Pais',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        $categories = [
            ['name' => 'Cybersegurança', 'description' => 'Artigos sobre segurança da informação, vulnerabilidades e defesa cibernética.'],
            ['name' => 'Pentest', 'description' => 'Testes de penetração, metodologias e ferramentas ofensivas.'],
            ['name' => 'Linux', 'description' => 'Administração de sistemas, hardening e ferramentas Linux.'],
            ['name' => 'DevOps', 'description' => 'CI/CD, containers, infraestrutura e automação.'],
            ['name' => 'Programação', 'description' => 'Desenvolvimento de software, frameworks e boas práticas.'],
        ];

        foreach ($categories as $cat) {
            Category::firstOrCreate(['slug' => \Illuminate\Support\Str::slug($cat['name'])], $cat);
        }

        $tagNames = [
            'Linux', 'Malware', 'Pentest', 'Red Team', 'Blue Team',
            'SQL Injection', 'XSS', 'Laravel', 'Docker', 'Golang',
            'Blockchain', 'DevOps', 'OWASP', 'Nmap', 'Wireshark',
        ];

        foreach ($tagNames as $name) {
            Tag::firstOrCreate(['slug' => \Illuminate\Support\Str::slug($name)], ['name' => $name]);
        }

        $posts = [
            [
                'title' => 'Introdução ao Hacking Ético e Pentest',
                'excerpt' => 'Entenda os fundamentos do hacking ético, metodologias de pentest e como iniciar na área de segurança ofensiva.',
                'markdown' => "# Introdução ao Hacking Ético\n\nO hacking ético é a prática de testar sistemas com autorização para identificar vulnerabilidades antes que atacantes maliciosos o façam.\n\n## Metodologias\n\n- **Reconhecimento**: Coleta de informações sobre o alvo\n- **Scanning**: Identificação de portas e serviços\n- **Exploração**: Teste de vulnerabilidades\n- **Pós-exploração**: Avaliação de impacto\n\n## Ferramentas Essenciais\n\n```bash\nnmap -sV -sC target.com\nsqlmap -u \"http://target.com/page?id=1\"\n```\n\n> Sempre obtenha autorização por escrito antes de realizar qualquer teste.\n\n## Checklist\n\n- [ ] Escopo definido\n- [ ] Autorização documentada\n- [ ] Ambiente de teste isolado\n- [ ] Relatório preparado",
                'category' => 'Pentest',
                'tags' => ['Pentest', 'Red Team', 'Nmap'],
                'status' => 'published',
            ],
            [
                'title' => 'Protegendo Aplicações Laravel contra OWASP Top 10',
                'excerpt' => 'Guia prático para implementar proteções contra as vulnerabilidades mais comuns em aplicações web Laravel.',
                'markdown' => "# OWASP Top 10 no Laravel\n\nO Laravel oferece proteções nativas contra muitas vulnerabilidades, mas a configuração correta é essencial.\n\n## SQL Injection\n\nUse sempre Eloquent ou Query Builder com Blade escapa automaticamente variáveis com `{{ }}`.\n\n## CSRF\n\nTodos os formulários devem incluir `@csrf`.\n\n## Rate Limiting\n\n```php\nRoute::post('/login', [AuthController::class, 'login'])\n    ->middleware('throttle:5,1');\n```",
                'category' => 'Programação',
                'tags' => ['Laravel', 'OWASP', 'SQL Injection', 'XSS'],
                'status' => 'published',
            ],
            [
                'title' => 'Hardening de Servidores Linux para Produção',
                'excerpt' => 'Passo a passo para configurar servidores Linux com foco em segurança para ambientes de produção.',
                'markdown' => "# Hardening Linux\n\nServidores Linux mal configurados são alvos fáceis. Siga este guia para fortalecer sua infraestrutura.\n\n## Configurações Básicas\n\n1. Desabilitar login root via SSH\n2. Usar chaves SSH em vez de senhas\n3. Configurar firewall (UFW/iptables)\n4. Manter pacotes atualizados\n\n```bash\nsudo ufw default deny incoming\nsudo ufw allow 22/tcp\nsudo ufw enable\n```\n\n## Monitoramento\n\n| Ferramenta | Função |\n|------------|--------|\n| fail2ban | Bloqueio de brute force |\n| auditd | Auditoria de sistema |\n| AIDE | Detecção de intrusão |",
                'category' => 'Linux',
                'tags' => ['Linux', 'DevOps', 'Blue Team'],
                'status' => 'published',
            ],
            [
                'title' => 'Docker para Ambientes de Pentest',
                'excerpt' => 'Como utilizar Docker para criar laboratórios isolados de pentest e praticar técnicas de segurança ofensiva.',
                'markdown' => "# Docker + Pentest\n\nContainers Docker são ideais para criar ambientes de laboratório reproduzíveis.\n\n## Lab Básico\n\n```yaml\nversion: '3'\nservices:\n  kali:\n    image: kalilinux/kali-rolling\n    tty: true\n  target:\n    image: vulnerables/web-dvwa\n    ports:\n      - \"8080:80\"\n```\n\n## Vantagens\n\n- Isolamento completo\n- Reproducibilidade\n- Fácil compartilhamento\n- Sem impacto no host",
                'category' => 'DevOps',
                'tags' => ['Docker', 'Pentest', 'Linux'],
                'status' => 'published',
            ],
            [
                'title' => 'Análise de Malware: Fundamentos e Ferramentas',
                'excerpt' => 'Conceitos básicos de análise de malware estático e dinâmico para profissionais de Blue Team.',
                'markdown' => "# Análise de Malware\n\nA análise de malware é essencial para entender ameaças e desenvolver contramedidas.\n\n## Tipos de Análise\n\n### Estática\n\nExame do binário sem execução:\n\n```bash\nfile malware.exe\nstrings malware.exe\npeframe malware.exe\n```\n\n### Dinâmica\n\nExecução em sandbox monitorada.\n\n## Indicadores de Comprometimento (IOCs)\n\n- Hashes de arquivo\n- Domínios C2\n- IPs maliciosos\n- Padrões de registry",
                'category' => 'Cybersegurança',
                'tags' => ['Malware', 'Blue Team', 'Linux'],
                'status' => 'published',
            ],
        ];

        foreach ($posts as $index => $postData) {
            $category = Category::where('name', $postData['category'])->first();
            $tags = $postData['tags'];
            unset($postData['category'], $postData['tags']);

            $post = Post::firstOrCreate(
                ['slug' => \Illuminate\Support\Str::slug($postData['title'])],
                array_merge($postData, [
                    'user_id' => $user->id,
                    'category_id' => $category->id,
                    'published_at' => now()->subDays($index),
                    'views_count' => rand(50, 500),
                ])
            );

            $tagIds = Tag::whereIn('name', $tags)->pluck('id');
            $post->tags()->sync($tagIds);
        }
    }
}
