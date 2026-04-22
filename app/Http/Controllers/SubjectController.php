<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubjectController extends Controller
{
    private $subjects = [
        'public-administrative-financial' => [
            'title' => 'Public Administrative & Financial',
            'description' => 'Core public administration, governance processes, and responsible public financial management.',
            'content' => 'This subject area covers core administrative systems and public financial fundamentals that support effective, transparent, and accountable local governance.',
            'image' => 'images/core-governance-training.png',
            'type' => 'subject-area',
        ],
        'technical-infrastructure' => [
            'title' => 'Technical & Infrastructure',
            'description' => 'Building and maintaining essential public infrastructure and technical services.',
            'content' => 'This subject area focuses on technical competencies and infrastructure-related programs that improve public service delivery and local development outcomes.',
            'image' => 'images/Basic Services.png',
            'type' => 'subject-area',
        ],
        'information-technology' => [
            'title' => 'Information & Technology',
            'description' => 'Digital tools, ICT applications, and technology-enabled public service delivery.',
            'content' => 'This subject area covers ICT fundamentals, digital systems, and practical technology skills that improve productivity and support modern governance.',
            'image' => 'images/digital.jpeg',
            'type' => 'subject-area',
        ],
        'health-social-services' => [
            'title' => 'Health & Social Services',
            'description' => 'Programs and systems that support public health, social welfare, and inclusive services.',
            'content' => 'This subject area focuses on strengthening local systems and service delivery approaches for public health and social services.',
            'image' => 'images/Basic Services.png',
            'type' => 'subject-area',
        ],
        'public-safety-regulation' => [
            'title' => 'Public Safety & Regulation',
            'description' => 'Public safety, compliance, risk reduction, and regulatory functions in local governance.',
            'content' => 'This subject area covers key concepts and approaches that promote safe communities, compliance, and effective regulation.',
            'image' => 'images/core-governance-training.png',
            'type' => 'subject-area',
        ],
        'legal-governance' => [
            'title' => 'Legal & Governance',
            'description' => 'Legal frameworks, governance standards, and regulatory decision-making.',
            'content' => 'This subject area focuses on legal and governance fundamentals that support fair, transparent, and accountable public administration.',
            'image' => 'images/core-governance-training.png',
            'type' => 'subject-area',
        ],
        'business-economic-development' => [
            'title' => 'Business & Economic Development',
            'description' => 'Local economic development strategies, investment promotion, and enterprise support.',
            'content' => 'This subject area covers approaches for strengthening local economies, supporting enterprises, and enabling inclusive growth.',
            'image' => 'images/eco.jpeg',
            'type' => 'subject-area',
        ],
        'environment-agriculture' => [
            'title' => 'Environment & Agriculture',
            'description' => 'Environmental management, climate resilience, and agriculture-related local programs.',
            'content' => 'This subject area focuses on sustainable practices and programs that support environmental stewardship and agriculture development.',
            'image' => 'images/community.jpeg',
            'type' => 'subject-area',
        ],
        'education-culture-community' => [
            'title' => 'Education, Culture & Community',
            'description' => 'Community learning, cultural development, and people-centered community programs.',
            'content' => 'This subject area supports education, culture, and community-oriented initiatives that strengthen local development and social cohesion.',
            'image' => 'images/community.jpeg',
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
        $aliases = [
            'core-governance-administration' => 'public-administrative-financial',
            'finance-compliance' => 'public-administrative-financial',
            'digital-transformation' => 'information-technology',
            'ict-technical-skills' => 'information-technology',
            'economic-business-development' => 'business-economic-development',
            'social-governance' => 'legal-governance',
            'human-capital-leadership' => 'education-culture-community',
            'community-development-planning' => 'education-culture-community',
        ];
        if (array_key_exists($slug, $aliases)) {
            $slug = $aliases[$slug];
        }

        if (!array_key_exists($slug, $this->subjects)) {
            abort(404);
        }

        $subject = $this->subjects[$slug];
        return view('subjects.show', compact('subject', 'slug'));
    }
}
