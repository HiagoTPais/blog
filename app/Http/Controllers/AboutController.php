<?php

namespace App\Http\Controllers;

use App\Services\SeoService;
use Inertia\Inertia;
use Inertia\Response;

class AboutController extends Controller
{
    public function __construct(private readonly SeoService $seoService) {}

    public function index(): Response
    {
        return Inertia::render('Blog/About', [
            'profile' => [
                'name' => 'Hiago Pais',
                'title' => 'Full Stack Developer & Cybersecurity Enthusiast',
                'email' => config('blog.author_email'),
                'phone' => '(77) 99914-6384',
                'github' => config('blog.github'),
                'linkedin' => config('blog.linkedin'),
                'avatar' => asset('img/photo.jpeg'),
                'resume_url' => asset('pdf/resume.pdf'),
                'bio' => 'Sou desenvolvedor Full Stack com foco em aplicações web seguras, escaláveis e de alta performance. Especializo-me em projetar, desenvolver e implementar sistemas web e de gestão empresarial, com forte base técnica e mentalidade analítica.',
                'summary' => implode("\n\n", [
                    'Desenvolvedor Full Stack com sólida experiência no desenvolvimento de aplicações web escaláveis e de alta performance, utilizando Laravel e Node.js no backend, além de Vue.js e React.js no frontend. Atua na criação de sistemas de gestão empresarial, APIs RESTful, microsserviços e integrações entre plataformas, com forte domínio em modelagem e otimização de bancos de dados MySQL, PostgreSQL e MongoDB.',
                    'Possui experiência em deploy, monitoramento e manutenção de aplicações em ambientes Linux, utilizando Docker para containerização e automação de processos com ferramentas como n8n, Node.js e scripts em Python, permitindo integração entre sistemas, criação de fluxos automatizados e otimização de tarefas operacionais.',
                    'Também possui experiência na integração de soluções de Inteligência Artificial em aplicações web, conectando APIs de IA para automação de tarefas, análise de dados, geração de conteúdo e desenvolvimento de assistentes inteligentes integrados a sistemas corporativos.',
                    'Profissional proativo, com foco na resolução de problemas complexos e na melhoria contínua de processos através de soluções tecnológicas eficientes, priorizando código limpo, escalabilidade, segurança e performance.',
                ]),
                'experience' => [
                    [
                        'role' => 'Programador',
                        'company' => 'Growe',
                        'period' => '02/2025 — 03/2026',
                        'description' => 'Desenvolvimento e manutenção de aplicações web com PHP, WordPress e MySQL.',
                        'highlights' => [
                            'Desenvolvimento de sistema tipo SaaS com Laravel, Inertia.js e interface SPA com React.js e TypeScript.',
                            'Desenvolvimento de landing pages e layouts para sites de eventos.',
                            'Implementação de automações de processos com n8n, integrando APIs e gestão de leads.',
                        ],
                    ],
                    [
                        'role' => 'Programador',
                        'company' => 'SmartBit',
                        'period' => '09/2024 — 01/2025',
                        'description' => 'Desenvolvimento de sistema tipo SaaS com Laravel, Inertia.js e interface SPA com Vue.js e TypeScript.',
                        'highlights' => [
                            'Desenvolvimento de testes unitários com PHPUnit.',
                        ],
                    ],
                    [
                        'role' => 'Programador',
                        'company' => 'NDB Software',
                        'period' => '02/2024 — 07/2024',
                        'description' => 'Desenvolvimento e manutenção de aplicações tipo SaaS em PHP, Laravel, Node.js e TypeScript.',
                        'highlights' => [
                            'Desenvolvimento de API RESTful com PHP, Laravel, Node.js e TypeScript.',
                            'Implementação de bancos PostgreSQL, MySQL e MongoDB.',
                            'Desenvolvimento de interface responsiva e landing page com ReactJS e Bootstrap.',
                            'Implementação de ambiente de desenvolvimento e produção com Docker.',
                        ],
                    ],
                    [
                        'role' => 'Programador',
                        'company' => 'PaiBahia',
                        'period' => '04/2023 — 08/2024',
                        'description' => 'Desenvolvimento de APIs e sistemas para administração comercial com PHP, Laravel e interface gráfica tipo SPA com Vue.js.',
                        'highlights' => [
                            'Desenvolvimento de aplicação com React Native.',
                        ],
                    ],
                    [
                        'role' => 'Programador',
                        'company' => 'CEA Arte Eletrônicas',
                        'period' => '07/2021 — 03/2023',
                        'description' => 'Desenvolvimento e manutenção de aplicações web com PHP, Laravel, MySQL, Node.js e TypeScript.',
                        'highlights' => [
                            'Construção de APIs REST e integração com Salesforce e Followize.',
                            'Desenvolvimento de sistemas de gestão comercial e layouts para sites de eventos.',
                            'Uso de Docker para facilitar o deploy e a escalabilidade das aplicações.',
                        ],
                    ],
                    [
                        'role' => 'Programador',
                        'company' => 'MicksTelecom',
                        'period' => '06/2019 — 05/2021',
                        'description' => 'Desenvolvimento de aplicações web com PHP, MySQL e Laravel, baseados na estrutura MVC.',
                        'highlights' => [
                            'Criação de dashboards utilizando PostgreSQL, MySQL e Grafana.',
                        ],
                    ],
                ],
                'technologies' => [
                    'Backend' => ['PHP', 'Laravel', 'Golang', 'MySQL', 'PostgreSQL', 'Redis'],
                    'Frontend' => ['Vue.js', 'React', 'Inertia.js', 'Tailwind CSS', 'JavaScript'],
                    'DevOps' => ['Docker', 'Linux', 'Grafana', 'CI/CD', 'Nginx'],
                    'Security' => ['Pentest', 'OWASP', 'Red Team', 'Blue Team', 'DevSecOps'],
                ],
                'projects' => [
                    [
                        'name' => 'Siena Church',
                        'description' => 'Sistema de galeria de imagens organizada e navegável a partir de repositório.',
                        'url' => null,
                    ],
                    [
                        'name' => 'Metricash',
                        'description' => 'Sistema de gestão financeira para controle de receitas, despesas e metas.',
                        'url' => null,
                    ],
                ],
                'goal' => 'Continuar evoluindo como desenvolvedor full stack com foco em segurança da informação, contribuindo para a comunidade de cybersegurança e compartilhando conhecimento técnico através deste blog.',
            ],
            'seo' => $this->seoService->forPage(
                'Sobre',
                'Conheça Hiago Pais — desenvolvedor Full Stack e entusiasta de cybersegurança.',
                'about'
            ),
        ]);
    }
}
