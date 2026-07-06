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
                'bio' => 'Sou desenvolvedor Full Stack com foco em aplicações web seguras, escaláveis e de alta performance. Especializo-me em projetar, desenvolver e implementar sistemas web e de gestão empresarial, com forte base técnica e mentalidade analítica.',
                'summary' => 'Minha expertise inclui construção e manutenção de aplicações com PHP, Laravel, MySQL e PostgreSQL, seguindo arquitetura MVC. Trabalho com Vue.js, React, Docker e integrações com plataformas como Salesforce. Tenho interesse especial em cybersegurança, hacking ético, pentest e DevSecOps.',
                'experience' => [
                    [
                        'role' => 'Full Stack Developer',
                        'company' => 'Freelancer / Projetos Próprios',
                        'period' => '2020 — Presente',
                        'description' => 'Desenvolvimento de sistemas web completos com Laravel, Vue.js e Docker. Integrações de API, otimização de performance e implementação de boas práticas de segurança.',
                    ],
                    [
                        'role' => 'System Developer',
                        'company' => 'SmartBit',
                        'period' => '2019 — 2023',
                        'description' => 'Desenvolvimento de sistemas comerciais, integrações SaaS e manutenção de aplicações Laravel/Vue.js em produção.',
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
                        'name' => 'PaiBahia',
                        'description' => 'Sistema de gestão funerária para atendimento ao cliente e gestão financeira.',
                        'url' => 'http://paibahia.com.br',
                    ],
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
