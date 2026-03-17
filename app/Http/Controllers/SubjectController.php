<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubjectController extends Controller
{
    private $subjects = [
        'core-governance-administration' => [
            'title' => 'Core Governance & Administration',
            'description' => 'Foundational principles of effective local governance and administrative management.',
            'content' => 'This subject area focuses on the essential frameworks that govern local administration. It covers the Local Government Code, parliamentary procedures for local legislative bodies, administrative office management, and public service ethics. Participants will learn how to effectively manage local government operations, ensure transparency, and uphold the highest standards of public service.',
            'image' => 'images/core-governance-training.png',
            'type' => 'subject-area',
        ],
        'finance-compliance' => [
            'title' => 'Finance & Compliance',
            'description' => 'Best practices in public financial management, budgeting, and auditing compliance.',
            'content' => 'Finance & Compliance provides in-depth training on local government budgeting, accounting, and auditing rules. It emphasizes adherence to COA (Commission on Audit) regulations, procurement laws (RA 9184), and revenue generation strategies. The goal is to ensure fiscal responsibility, transparency in financial transactions, and efficient utilization of public funds.',
             'image' => 'images/finance.jpeg',
             'type' => 'subject-area',
        ],
        'digital-transformation' => [
            'title' => 'Digital Transformation',
            'description' => 'Leveraging technology to modernize local government operations and service delivery.',
            'content' => 'This area explores the integration of digital technologies into local governance. Topics include e-governance strategies, digital record-keeping, online service delivery platforms, and data privacy security. It aims to equip LGUs with the tools to streamline processes, reduce red tape, and improve accessibility for citizens through digital innovation.',
             'image' => 'images/digital.jpeg',
             'type' => 'subject-area',
        ],
        'ict-technical-skills' => [
            'title' => 'ICT & Technical Skills',
            'description' => 'Developing technical proficiency in Information and Communications Technology.',
            'content' => 'ICT & Technical Skills focuses on the practical application of technology in the workplace. From basic computer literacy to advanced network management and cybersecurity, this subject ensures that government personnel are proficient in using modern ICT tools. It also covers technical writing, data analysis, and the maintenance of IT infrastructure.',
             'image' => 'images/ict.jpeg',
             'type' => 'subject-area',
        ],
        'human-capital-leadership' => [
            'title' => 'Human Capital & Leadership',
            'description' => 'Empowering public servants through leadership development and human resource management.',
            'content' => 'This subject area is dedicated to the development of human resources within the LGU. It covers strategic HR management, performance evaluation systems, and leadership training. The curriculum is designed to foster a culture of excellence, motivation, and continuous professional development among local government employees and officials.',
             'image' => 'images/human.jpeg',
             'type' => 'subject-area',
        ],
        'community-development-planning' => [
            'title' => 'Community & Development Planning',
            'description' => 'Strategic planning for sustainable community development and inclusive growth.',
            'content' => 'Community & Development Planning focuses on the formulation and implementation of comprehensive development plans. It covers land use planning, disaster risk reduction and management (DRRM), and participatory planning processes. Participants will learn how to engage communities, assess needs, and create sustainable development roadmaps.',
             'image' => 'images/community.jpeg',
             'type' => 'subject-area',
        ],
        'economic-business-development' => [
            'title' => 'Economic & Business Development',
            'description' => 'Strategies for boosting local economy, attracting investments, and supporting MSMEs.',
            'content' => 'This area aims to strengthen the local economy through business-friendly policies and investment promotion. Topics include local economic development (LED) strategies, support for Micro, Small, and Medium Enterprises (MSMEs), and public-private partnerships. It empowers LGUs to create an enabling environment for business growth and job creation.',
             'image' => 'images/eco.jpeg',
             'type' => 'subject-area',
        ],
        'social-governance' => [
            'title' => 'Social Governance',
            'description' => 'Enhancing social services and promoting social justice and welfare.',
            'content' => 'Social Governance addresses the delivery of essential social services such as health, education, and social welfare. It covers gender and development (GAD), child protection, and programs for vulnerable sectors. The focus is on ensuring equitable access to services and promoting the well-being of all community members.',
             'image' => 'images/social.jpeg',
             'type' => 'subject-area',
        ],
        // Available Courses
        'basic-research' => [
            'title' => 'BASIC RESEARCH',
            'description' => 'Learn the fundamentals of research methodology, data collection, and analysis tailored for local governance applications.',
            'content' => 'This course provides a comprehensive introduction to research methodologies suitable for local governance. Participants will learn how to design research studies, collect and analyze data, and interpret findings to inform policy-making and program implementation. The course emphasizes practical applications, ensuring that learners can conduct rigorous research to address local challenges.',
            'image' => 'images/Basic Research.png',
            'type' => 'course',
        ],
        'basic-services-facilities' => [
            'title' => 'BASIC SERVICES AND FACILITIES',
            'description' => 'Understand the essential services and facilities that Local Government Units are mandated to provide to their constituents.',
            'content' => 'This course outlines the mandatory basic services and facilities that LGUs must provide under the Local Government Code. It covers health services, social welfare, hygiene and sanitation, and infrastructure support. Participants will explore strategies for efficient service delivery and facility management to ensure the well-being and satisfaction of their constituents.',
            'image' => 'images/Basic Services.png',
            'type' => 'course',
        ],
        'nature-types-local-governments' => [
            'title' => 'NATURE AND TYPES OF LOCAL GOVERNMENTS',
            'description' => 'Explore the different types of LGUs in the Philippines, their distinct roles, powers, and functions in the political structure.',
            'content' => 'This course examines the classification and structure of Local Government Units in the Philippines, including Provinces, Cities, Municipalities, and Barangays. It delves into their specific roles, powers, and responsibilities within the broader political framework. Learners will gain a clear understanding of the hierarchy and inter-relationships among different levels of local government.',
            'image' => 'images/Nature and Types.png',
            'type' => 'course',
        ],
        'creation-lgu' => [
            'title' => 'CREATION, CONVERSION, DIVISION, MERGER, AND ABOLITION OF LGUs',
            'description' => 'A comprehensive guide on the legal processes and requirements for creating, modifying, or dissolving Local Government Units.',
            'content' => 'This course details the legal and procedural requirements for the creation, conversion, division, merger, and abolition of LGUs. It covers the criteria for population, land area, and income, as well as the plebiscite requirements. Participants will understand the implications of these changes on governance, administration, and resource allocation.',
            'image' => 'images/Creation.png',
            'type' => 'course',
        ],
        'local-autonomy-decentralization' => [
            'title' => 'LOCAL AUTONOMY AND SYSTEM OF DECENTRALIZATION',
            'description' => 'Deep dive into the principles of local autonomy and decentralization as enshrined in the Constitution and the Local Government Code.',
            'content' => 'This course explores the constitutional and legal foundations of local autonomy and decentralization in the Philippines. It analyzes the devolution of powers, the fiscal autonomy of LGUs, and the relationship between the national and local governments. The course aims to empower local officials to fully exercise their autonomous powers for the benefit of their communities.',
            'image' => 'images/Local Autonomy.png',
            'type' => 'course',
        ],
    ];

    public function show($slug)
    {
        if (!array_key_exists($slug, $this->subjects)) {
            abort(404);
        }

        $subject = $this->subjects[$slug];
        return view('subjects.show', compact('subject', 'slug'));
    }
}
