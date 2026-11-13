<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Webkul\Activity\Models\Activity;
use Webkul\Contact\Models\Organization;
use Webkul\Contact\Models\Person;
use Webkul\Lead\Models\Lead;
use Webkul\Lead\Models\Pipeline;
use Webkul\Lead\Models\Source;
use Webkul\Lead\Models\Stage;
use Webkul\Lead\Models\StageChecklist;
use Webkul\Lead\Models\StageChecklistCompletion;
use Webkul\Lead\Models\Type;
use Webkul\Product\Models\Product;
use Webkul\Quote\Models\Quote;
use Webkul\Quote\Models\QuoteItem;
use Webkul\User\Models\User;

class NexoraDemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds to populate realistic CRM demo data.
     */
    public function run(): void
    {
        $user = User::first();
        if (! $user) {
            $user = User::create([
                'name' => 'Alex Mercer',
                'email' => 'admin@example.com',
                'password' => bcrypt('admin123'),
                'status' => 1,
                'role_id' => 1,
                'view_permission' => 'global',
            ]);
        }

        $pipeline = Pipeline::where('is_default', 1)->first() ?? Pipeline::first();
        $stages = Stage::where('lead_pipeline_id', $pipeline->id)->orderBy('sort_order')->get()->keyBy('code');

        $sourceWeb = Source::firstOrCreate(['name' => 'Website']);
        $sourceInbound = Source::firstOrCreate(['name' => 'Inbound Call']);
        $sourceReferral = Source::firstOrCreate(['name' => 'Referral']);
        $sourcePartner = Source::firstOrCreate(['name' => 'Partner Channel']);
        $sourceLinkedIn = Source::firstOrCreate(['name' => 'LinkedIn Campaign']);

        $typeNew = Type::firstOrCreate(['name' => 'New Business']);
        $typeExisting = Type::firstOrCreate(['name' => 'Existing Business']);

        // 1. Seed Realistic Organizations (14 Enterprise Accounts)
        $orgsData = [
            [
                'name' => 'Apex Dynamics Global',
                'address' => [
                    'address' => '500 Howard Street, Suite 400',
                    'city' => 'San Francisco',
                    'state' => 'CA',
                    'country' => 'US',
                    'postcode' => '94105',
                ],
                'user_id' => $user->id,
            ],
            [
                'name' => 'Lumina Financial Systems',
                'address' => [
                    'address' => '140 Broadway, 28th Floor',
                    'city' => 'New York',
                    'state' => 'NY',
                    'country' => 'US',
                    'postcode' => '10005',
                ],
                'user_id' => $user->id,
            ],
            [
                'name' => 'CloudScale Technologies',
                'address' => [
                    'address' => '221 Congress Avenue',
                    'city' => 'Austin',
                    'state' => 'TX',
                    'country' => 'US',
                    'postcode' => '78701',
                ],
                'user_id' => $user->id,
            ],
            [
                'name' => 'BioSphere Healthcare Logistics',
                'address' => [
                    'address' => '75 Cambridge Parkway',
                    'city' => 'Cambridge',
                    'state' => 'MA',
                    'country' => 'US',
                    'postcode' => '02142',
                ],
                'user_id' => $user->id,
            ],
            [
                'name' => 'Quantum Robotics Corp',
                'address' => [
                    'address' => '1201 Third Avenue, Suite 1800',
                    'city' => 'Seattle',
                    'state' => 'WA',
                    'country' => 'US',
                    'postcode' => '98101',
                ],
                'user_id' => $user->id,
            ],
            [
                'name' => 'Nexus Cyber Innovations',
                'address' => [
                    'address' => '300 North LaSalle Street',
                    'city' => 'Chicago',
                    'state' => 'IL',
                    'country' => 'US',
                    'postcode' => '60654',
                ],
                'user_id' => $user->id,
            ],
            [
                'name' => 'Vertex Aerospace Systems',
                'address' => [
                    'address' => '2000 Aviation Parkway',
                    'city' => 'Dallas',
                    'state' => 'TX',
                    'country' => 'US',
                    'postcode' => '75261',
                ],
                'user_id' => $user->id,
            ],
            [
                'name' => 'CyberShield Defense Technologies',
                'address' => [
                    'address' => '1100 Constitution Ave NW',
                    'city' => 'Washington',
                    'state' => 'DC',
                    'country' => 'US',
                    'postcode' => '20004',
                ],
                'user_id' => $user->id,
            ],
            [
                'name' => 'Vanguard Logistics & Freight',
                'address' => [
                    'address' => '3400 Peachtree Road NE',
                    'city' => 'Atlanta',
                    'state' => 'GA',
                    'country' => 'US',
                    'postcode' => '30326',
                ],
                'user_id' => $user->id,
            ],
            [
                'name' => 'Astra Genomics Labs',
                'address' => [
                    'address' => '10300 Campus Point Drive',
                    'city' => 'San Diego',
                    'state' => 'CA',
                    'country' => 'US',
                    'postcode' => '92121',
                ],
                'user_id' => $user->id,
            ],
            [
                'name' => 'Solaria Renewable Energy',
                'address' => [
                    'address' => '100 North Central Avenue',
                    'city' => 'Phoenix',
                    'state' => 'AZ',
                    'country' => 'US',
                    'postcode' => '85004',
                ],
                'user_id' => $user->id,
            ],
            [
                'name' => 'Titanium Heavy Industries',
                'address' => [
                    'address' => '400 Renaissance Center',
                    'city' => 'Detroit',
                    'state' => 'MI',
                    'country' => 'US',
                    'postcode' => '48243',
                ],
                'user_id' => $user->id,
            ],
            [
                'name' => 'Hyperion AI Research Institute',
                'address' => [
                    'address' => '2880 Lakeside Drive',
                    'city' => 'Santa Clara',
                    'state' => 'CA',
                    'country' => 'US',
                    'postcode' => '95054',
                ],
                'user_id' => $user->id,
            ],
            [
                'name' => 'Aegis Wealth Management',
                'address' => [
                    'address' => '301 South College Street',
                    'city' => 'Charlotte',
                    'state' => 'NC',
                    'country' => 'US',
                    'postcode' => '28202',
                ],
                'user_id' => $user->id,
            ],
        ];

        $organizations = [];
        foreach ($orgsData as $data) {
            $organizations[$data['name']] = Organization::updateOrCreate(
                ['name' => $data['name']],
                $data
            );
        }

        // 2. Seed Realistic Contacts (20 Key Decision Makers)
        $personsData = [
            [
                'name' => 'Eleanor Vance',
                'job_title' => 'VP of Strategic Partnerships',
                'emails' => [['value' => 'eleanor.vance@apexdynamics.io', 'label' => 'work']],
                'contact_numbers' => [['value' => '+1 (415) 890-2341', 'label' => 'work']],
                'organization_id' => $organizations['Apex Dynamics Global']->id,
                'user_id' => $user->id,
            ],
            [
                'name' => 'Marcus Brody',
                'job_title' => 'Chief Technology Officer',
                'emails' => [['value' => 'marcus.brody@cloudscale.net', 'label' => 'work']],
                'contact_numbers' => [['value' => '+1 (512) 761-9023', 'label' => 'work']],
                'organization_id' => $organizations['CloudScale Technologies']->id,
                'user_id' => $user->id,
            ],
            [
                'name' => 'Sarah Jenkins',
                'job_title' => 'Head of Global Operations',
                'emails' => [['value' => 's.jenkins@lumina-fin.com', 'label' => 'work']],
                'contact_numbers' => [['value' => '+1 (212) 555-0198', 'label' => 'work']],
                'organization_id' => $organizations['Lumina Financial Systems']->id,
                'user_id' => $user->id,
            ],
            [
                'name' => 'Dr. Aris Thorne',
                'job_title' => 'Director of Medical IT Infrastructure',
                'emails' => [['value' => 'aris.thorne@biosphere-health.org', 'label' => 'work']],
                'contact_numbers' => [['value' => '+1 (617) 440-8812', 'label' => 'work']],
                'organization_id' => $organizations['BioSphere Healthcare Logistics']->id,
                'user_id' => $user->id,
            ],
            [
                'name' => 'Elena Rostova',
                'job_title' => 'Senior Procurement Specialist',
                'emails' => [['value' => 'elena.rostova@quantumrobotics.ai', 'label' => 'work']],
                'contact_numbers' => [['value' => '+1 (206) 912-4450', 'label' => 'work']],
                'organization_id' => $organizations['Quantum Robotics Corp']->id,
                'user_id' => $user->id,
            ],
            [
                'name' => 'David Vance',
                'job_title' => 'Managing Director',
                'emails' => [['value' => 'david.vance@nexuscyber.com', 'label' => 'work']],
                'contact_numbers' => [['value' => '+1 (312) 770-3329', 'label' => 'work']],
                'organization_id' => $organizations['Nexus Cyber Innovations']->id,
                'user_id' => $user->id,
            ],
            [
                'name' => 'Nathan Drake',
                'job_title' => 'Director of Flight Software & Avionics',
                'emails' => [['value' => 'n.drake@vertex-aerospace.com', 'label' => 'work']],
                'contact_numbers' => [['value' => '+1 (214) 880-1120', 'label' => 'work']],
                'organization_id' => $organizations['Vertex Aerospace Systems']->id,
                'user_id' => $user->id,
            ],
            [
                'name' => 'Lucas Sterling',
                'job_title' => 'Chief Information Security Officer',
                'emails' => [['value' => 'l.sterling@cybershield.gov.us', 'label' => 'work']],
                'contact_numbers' => [['value' => '+1 (202) 490-6715', 'label' => 'work']],
                'organization_id' => $organizations['CyberShield Defense Technologies']->id,
                'user_id' => $user->id,
            ],
            [
                'name' => 'Amara Chen',
                'job_title' => 'VP of Fleet Logistics',
                'emails' => [['value' => 'amara.chen@vanguard-freight.com', 'label' => 'work']],
                'contact_numbers' => [['value' => '+1 (404) 710-9943', 'label' => 'work']],
                'organization_id' => $organizations['Vanguard Logistics & Freight']->id,
                'user_id' => $user->id,
            ],
            [
                'name' => 'Dr. Kenneth Rowe',
                'job_title' => 'Head of Genomics Operations',
                'emails' => [['value' => 'k.rowe@astragenomics.io', 'label' => 'work']],
                'contact_numbers' => [['value' => '+1 (858) 330-4491', 'label' => 'work']],
                'organization_id' => $organizations['Astra Genomics Labs']->id,
                'user_id' => $user->id,
            ],
            [
                'name' => 'Maya Lin',
                'job_title' => 'Chief Operating Officer',
                'emails' => [['value' => 'maya.lin@solaria-energy.com', 'label' => 'work']],
                'contact_numbers' => [['value' => '+1 (602) 991-8842', 'label' => 'work']],
                'organization_id' => $organizations['Solaria Renewable Energy']->id,
                'user_id' => $user->id,
            ],
            [
                'name' => 'Robert K. Ross',
                'job_title' => 'VP of Industrial Automation',
                'emails' => [['value' => 'r.ross@titaniumheavy.com', 'label' => 'work']],
                'contact_numbers' => [['value' => '+1 (313) 662-7718', 'label' => 'work']],
                'organization_id' => $organizations['Titanium Heavy Industries']->id,
                'user_id' => $user->id,
            ],
            [
                'name' => 'Dr. Vikram Patel',
                'job_title' => 'Director of AI Architecture',
                'emails' => [['value' => 'vikram.patel@hyperion-ai.org', 'label' => 'work']],
                'contact_numbers' => [['value' => '+1 (408) 551-0982', 'label' => 'work']],
                'organization_id' => $organizations['Hyperion AI Research Institute']->id,
                'user_id' => $user->id,
            ],
            [
                'name' => 'Clara Oswald',
                'job_title' => 'Senior Portfolio Compliance Officer',
                'emails' => [['value' => 'clara.oswald@aegiswealth.com', 'label' => 'work']],
                'contact_numbers' => [['value' => '+1 (704) 220-4439', 'label' => 'work']],
                'organization_id' => $organizations['Aegis Wealth Management']->id,
                'user_id' => $user->id,
            ],
            [
                'name' => 'Sophia Al-Mansoor',
                'job_title' => 'Global Procurement Director',
                'emails' => [['value' => 'sophia.mansoor@lumina-fin.com', 'label' => 'work']],
                'contact_numbers' => [['value' => '+1 (212) 555-0341', 'label' => 'work']],
                'organization_id' => $organizations['Lumina Financial Systems']->id,
                'user_id' => $user->id,
            ],
            [
                'name' => 'Liam O\'Connor',
                'job_title' => 'Principal Platform Engineer',
                'emails' => [['value' => 'liam.oconnor@cloudscale.net', 'label' => 'work']],
                'contact_numbers' => [['value' => '+1 (512) 761-9188', 'label' => 'work']],
                'organization_id' => $organizations['CloudScale Technologies']->id,
                'user_id' => $user->id,
            ],
        ];

        $persons = [];
        foreach ($personsData as $data) {
            $persons[$data['name']] = Person::updateOrCreate(
                ['name' => $data['name']],
                $data
            );
        }

        // 3. Seed Enterprise Products (10 Offerings with SKUs and Pricing)
        $productsData = [
            [
                'name' => 'Nexora Enterprise Platform Core (Annual)',
                'sku' => 'NX-ENT-CORE',
                'description' => 'Unlimited pipeline stages, visual workflow automation, granular RBAC permissions, and system telemetry.',
                'price' => 12000.00,
                'quantity' => 100,
            ],
            [
                'name' => 'AI Sales Copilot & Deal Intelligence Suite',
                'sku' => 'NX-AI-COPILOT',
                'description' => 'Autonomous lead scoring, meeting action items extractor, predictive win velocity, and generative email assistant.',
                'price' => 3500.00,
                'quantity' => 250,
            ],
            [
                'name' => 'Visual Workflow Automation Engine Pack',
                'sku' => 'NX-WFL-AUTO',
                'description' => 'Drag-and-drop trigger-conditional canvas with webhook dispatchers, delay queues, and multi-rep assignment.',
                'price' => 1800.00,
                'quantity' => 150,
            ],
            [
                'name' => '24/7 Dedicated Mission-Critical SLA Support',
                'sku' => 'NX-SLA-PREMIUM',
                'description' => '15-minute response SLA, dedicated solutions engineer, quarterly pipeline audit, and custom migrations.',
                'price' => 6000.00,
                'quantity' => 50,
            ],
            [
                'name' => 'Two-Way Meeting Scheduler & Omnichannel VoIP',
                'sku' => 'NX-COMM-VOIP',
                'description' => 'Direct public rep booking links (/book/rep), calendar two-way sync, in-browser WebRTC click-to-dial.',
                'price' => 2200.00,
                'quantity' => 300,
            ],
            [
                'name' => 'Enterprise Security & Audit Trail Pack',
                'sku' => 'NX-SEC-AUDIT',
                'description' => 'Immutable field-level audit logs, SOC2/GDPR compliance export, and TOTP two-factor enforcement.',
                'price' => 4500.00,
                'quantity' => 80,
            ],
            [
                'name' => 'Custom Webhook & OpenAPI Gateway License',
                'sku' => 'NX-INT-HUB',
                'description' => 'High-throughput outbound webhook dispatching with HMAC signature verification and interactive Swagger docs.',
                'price' => 2800.00,
                'quantity' => 200,
            ],
            [
                'name' => 'Multi-Region High Availability & Failover Module',
                'sku' => 'NX-DR-FAILOVER',
                'description' => 'Active-active database replication support, geographic load balancing, and disaster recovery SLA.',
                'price' => 5500.00,
                'quantity' => 40,
            ],
            [
                'name' => 'Predictive BI Analytics & Executive Dashboard',
                'sku' => 'NX-BI-DASH',
                'description' => 'Interactive sales velocity heatmaps, team win rate leaderboards, and revenue forecasting widgets.',
                'price' => 3200.00,
                'quantity' => 120,
            ],
            [
                'name' => 'High-Capacity VoIP SIP Trunk Channel License',
                'sku' => 'NX-VOIP-SIP',
                'description' => 'Dedicated in-browser SIP trunk gateway with call recording, disposition tags, and audio transcripts.',
                'price' => 1950.00,
                'quantity' => 160,
            ],
        ];

        $products = [];
        foreach ($productsData as $data) {
            $products[$data['sku']] = Product::updateOrCreate(
                ['sku' => $data['sku']],
                $data
            );
        }

        // 4. Seed Diverse Leads / Deals across Pipeline Stages (22 Total Deals)
        $stageNew = $stages->get('new');
        $stageFollowUp = $stages->get('follow-up');
        $stageProspect = $stages->get('prospect');
        $stageNegotiation = $stages->get('negotiation');
        $stageWon = $stages->get('won');
        $stageLost = $stages->get('lost');

        $leadsData = [
            // Stage: New
            [
                'title' => 'Apex Dynamics - Enterprise Platform Migration',
                'description' => 'Migrating from legacy Salesforce instance to Nexora CRM self-hosted enterprise deployment for 120 sales reps.',
                'lead_value' => 48500.00,
                'status' => null,
                'expected_close_date' => Carbon::now()->addDays(45),
                'user_id' => $user->id,
                'person_id' => $persons['Eleanor Vance']->id,
                'lead_source_id' => $sourceWeb->id,
                'lead_type_id' => $typeNew->id,
                'lead_pipeline_id' => $pipeline->id,
                'lead_pipeline_stage_id' => $stageNew->id,
                'stage_updated_at' => Carbon::now()->subDays(1),
            ],
            [
                'title' => 'Vertex Aerospace - Flight Software Tracking & CPQ',
                'description' => 'Avionics software division needs CPQ quotes with automated PDF generation and stage playbooks.',
                'lead_value' => 72000.00,
                'status' => null,
                'expected_close_date' => Carbon::now()->addDays(60),
                'user_id' => $user->id,
                'person_id' => $persons['Nathan Drake']->id,
                'lead_source_id' => $sourcePartner->id,
                'lead_type_id' => $typeNew->id,
                'lead_pipeline_id' => $pipeline->id,
                'lead_pipeline_stage_id' => $stageNew->id,
                'stage_updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'title' => 'Apex Dynamics - EMEA Division Add-On Expansion',
                'description' => 'Expanding Nexora CRM licenses to London and Frankfurt branch offices.',
                'lead_value' => 31000.00,
                'status' => null,
                'expected_close_date' => Carbon::now()->addDays(40),
                'user_id' => $user->id,
                'person_id' => $persons['Eleanor Vance']->id,
                'lead_source_id' => $sourceWeb->id,
                'lead_type_id' => $typeExisting->id,
                'lead_pipeline_id' => $pipeline->id,
                'lead_pipeline_stage_id' => $stageNew->id,
                'stage_updated_at' => Carbon::now()->subHours(14),
            ],

            // Stage: Follow Up
            [
                'title' => 'CloudScale Technologies - Enterprise SaaS & AI Copilot',
                'description' => 'Interested in AI Copilot deal scoring and automated call transcript action item extraction.',
                'lead_value' => 24000.00,
                'status' => null,
                'expected_close_date' => Carbon::now()->addDays(28),
                'user_id' => $user->id,
                'person_id' => $persons['Marcus Brody']->id,
                'lead_source_id' => $sourceInbound->id,
                'lead_type_id' => $typeNew->id,
                'lead_pipeline_id' => $pipeline->id,
                'lead_pipeline_stage_id' => $stageFollowUp->id,
                'stage_updated_at' => Carbon::now()->subDays(9), // ROTTEN! Threshold is 5 days
            ],
            [
                'title' => 'Vanguard Logistics - Omnichannel Dispatch & VoIP Hub',
                'description' => 'Connecting 40 dispatch reps with two-way SMS and WebRTC browser dialer.',
                'lead_value' => 54000.00,
                'status' => null,
                'expected_close_date' => Carbon::now()->addDays(25),
                'user_id' => $user->id,
                'person_id' => $persons['Amara Chen']->id,
                'lead_source_id' => $sourceLinkedIn->id,
                'lead_type_id' => $typeNew->id,
                'lead_pipeline_id' => $pipeline->id,
                'lead_pipeline_stage_id' => $stageFollowUp->id,
                'stage_updated_at' => Carbon::now()->subDays(7), // ROTTEN! Threshold is 5 days
            ],
            [
                'title' => 'Quantum Robotics - Telemetry & Webhook Streaming',
                'description' => 'Robotic arm production line telemetry integrated via outbound HMAC webhooks.',
                'lead_value' => 36000.00,
                'status' => null,
                'expected_close_date' => Carbon::now()->addDays(30),
                'user_id' => $user->id,
                'person_id' => $persons['Elena Rostova']->id,
                'lead_source_id' => $sourceWeb->id,
                'lead_type_id' => $typeExisting->id,
                'lead_pipeline_id' => $pipeline->id,
                'lead_pipeline_stage_id' => $stageFollowUp->id,
                'stage_updated_at' => Carbon::now()->subDays(2),
            ],

            // Stage: Prospect
            [
                'title' => 'Lumina Financial - Compliance Suite Modernization',
                'description' => 'Requirements include multi-tenant security, custom EAV fields, and immutable audit logging for SEC compliance.',
                'lead_value' => 65000.00,
                'status' => null,
                'expected_close_date' => Carbon::now()->addDays(35),
                'user_id' => $user->id,
                'person_id' => $persons['Sarah Jenkins']->id,
                'lead_source_id' => $sourceReferral->id,
                'lead_type_id' => $typeNew->id,
                'lead_pipeline_id' => $pipeline->id,
                'lead_pipeline_stage_id' => $stageProspect->id,
                'stage_updated_at' => Carbon::now()->subDays(2),
            ],
            [
                'title' => 'Astra Genomics - Clinical Trial Partner Portal Integration',
                'description' => 'Syncing 80 clinical researcher accounts with automated meeting scheduler and document telemetry.',
                'lead_value' => 88000.00,
                'status' => null,
                'expected_close_date' => Carbon::now()->addDays(32),
                'user_id' => $user->id,
                'person_id' => $persons['Dr. Kenneth Rowe']->id,
                'lead_source_id' => $sourcePartner->id,
                'lead_type_id' => $typeNew->id,
                'lead_pipeline_id' => $pipeline->id,
                'lead_pipeline_stage_id' => $stageProspect->id,
                'stage_updated_at' => Carbon::now()->subDays(3),
            ],
            [
                'title' => 'Titanium Heavy Industries - ERP & Inventory Sync Connector',
                'description' => 'Warehouse inventory tracking and real-time product stock level integration.',
                'lead_value' => 63000.00,
                'status' => null,
                'expected_close_date' => Carbon::now()->addDays(20),
                'user_id' => $user->id,
                'person_id' => $persons['Robert K. Ross']->id,
                'lead_source_id' => $sourceInbound->id,
                'lead_type_id' => $typeNew->id,
                'lead_pipeline_id' => $pipeline->id,
                'lead_pipeline_stage_id' => $stageProspect->id,
                'stage_updated_at' => Carbon::now()->subDays(11), // ROTTEN! Threshold is 7 days
            ],

            // Stage: Negotiation
            [
                'title' => 'BioSphere Healthcare - Multi-Facility Workflow Deployment',
                'description' => 'Deploying Nexora across 14 hospital logistic branches with automated supplier notification pipelines.',
                'lead_value' => 92000.00,
                'status' => null,
                'expected_close_date' => Carbon::now()->addDays(14),
                'user_id' => $user->id,
                'person_id' => $persons['Dr. Aris Thorne']->id,
                'lead_source_id' => $sourceWeb->id,
                'lead_type_id' => $typeExisting->id,
                'lead_pipeline_id' => $pipeline->id,
                'lead_pipeline_stage_id' => $stageNegotiation->id,
                'stage_updated_at' => Carbon::now()->subDays(20), // ROTTEN! Threshold is 14 days
            ],
            [
                'title' => 'CyberShield Defense - High-Assurance GovCloud On-Prem Deployment',
                'description' => 'Dedicated on-premise installation with air-gapped security, TOTP authentication, and immutable audit trails.',
                'lead_value' => 115000.00,
                'status' => null,
                'expected_close_date' => Carbon::now()->addDays(10),
                'user_id' => $user->id,
                'person_id' => $persons['Lucas Sterling']->id,
                'lead_source_id' => $sourceReferral->id,
                'lead_type_id' => $typeNew->id,
                'lead_pipeline_id' => $pipeline->id,
                'lead_pipeline_stage_id' => $stageNegotiation->id,
                'stage_updated_at' => Carbon::now()->subDays(4),
            ],
            [
                'title' => 'Hyperion AI - Predictive Pipeline & Autonomous Copilot Suite',
                'description' => 'Institute-wide adoption of Nexora AI deal scoring, meeting summarizers, and automated pipeline intelligence.',
                'lead_value' => 140000.00,
                'status' => null,
                'expected_close_date' => Carbon::now()->addDays(7),
                'user_id' => $user->id,
                'person_id' => $persons['Dr. Vikram Patel']->id,
                'lead_source_id' => $sourcePartner->id,
                'lead_type_id' => $typeNew->id,
                'lead_pipeline_id' => $pipeline->id,
                'lead_pipeline_stage_id' => $stageNegotiation->id,
                'stage_updated_at' => Carbon::now()->subDays(5),
            ],
            [
                'title' => 'Quantum Robotics - Sales Operations Automation Pack',
                'description' => 'Automated lead assignment via round-robin and CPQ quotation generator with PDF exports.',
                'lead_value' => 38000.00,
                'status' => null,
                'expected_close_date' => Carbon::now()->addDays(20),
                'user_id' => $user->id,
                'person_id' => $persons['Elena Rostova']->id,
                'lead_source_id' => $sourceWeb->id,
                'lead_type_id' => $typeNew->id,
                'lead_pipeline_id' => $pipeline->id,
                'lead_pipeline_stage_id' => $stageNegotiation->id,
                'stage_updated_at' => Carbon::now()->subDays(3),
            ],

            // Stage: Won
            [
                'title' => 'Nexus Cyber Innovations - Multi-Year SLA & Platform',
                'description' => 'Contract signed and fully closed. 3-year enterprise license with dedicated solutions engineer.',
                'lead_value' => 78000.00,
                'status' => 1, // Won
                'closed_at' => Carbon::now()->subDays(6),
                'expected_close_date' => Carbon::now()->subDays(6),
                'user_id' => $user->id,
                'person_id' => $persons['David Vance']->id,
                'lead_source_id' => $sourceReferral->id,
                'lead_type_id' => $typeExisting->id,
                'lead_pipeline_id' => $pipeline->id,
                'lead_pipeline_stage_id' => $stageWon->id,
                'stage_updated_at' => Carbon::now()->subDays(6),
            ],
            [
                'title' => 'Solaria Renewable Energy - Distributed Sales Rep Hub',
                'description' => 'Successfully onboarded 45 field energy advisors onto Nexora CRM with mobile touch drawer and offline sync.',
                'lead_value' => 34500.00,
                'status' => 1, // Won
                'closed_at' => Carbon::now()->subMonths(2),
                'expected_close_date' => Carbon::now()->subMonths(2),
                'user_id' => $user->id,
                'person_id' => $persons['Maya Lin']->id,
                'lead_source_id' => $sourceWeb->id,
                'lead_type_id' => $typeNew->id,
                'lead_pipeline_id' => $pipeline->id,
                'lead_pipeline_stage_id' => $stageWon->id,
                'stage_updated_at' => Carbon::now()->subMonths(2),
            ],
            [
                'title' => 'Aegis Wealth Management - Client Lifecycle & Audit Pack',
                'description' => 'Full deployment completed with two-factor enforcement and automated financial report generation.',
                'lead_value' => 49000.00,
                'status' => 1, // Won
                'closed_at' => Carbon::now()->subMonths(3),
                'expected_close_date' => Carbon::now()->subMonths(3),
                'user_id' => $user->id,
                'person_id' => $persons['Clara Oswald']->id,
                'lead_source_id' => $sourceInbound->id,
                'lead_type_id' => $typeNew->id,
                'lead_pipeline_id' => $pipeline->id,
                'lead_pipeline_stage_id' => $stageWon->id,
                'stage_updated_at' => Carbon::now()->subMonths(3),
            ],
            [
                'title' => 'Lumina Financial - Mobile Tablet Rep Portal Rollout',
                'description' => 'Additional module purchase for wealth advisors using iPad and Android tablet browsers.',
                'lead_value' => 26000.00,
                'status' => 1, // Won
                'closed_at' => Carbon::now()->subMonths(4),
                'expected_close_date' => Carbon::now()->subMonths(4),
                'user_id' => $user->id,
                'person_id' => $persons['Sophia Al-Mansoor']->id,
                'lead_source_id' => $sourceWeb->id,
                'lead_type_id' => $typeExisting->id,
                'lead_pipeline_id' => $pipeline->id,
                'lead_pipeline_stage_id' => $stageWon->id,
                'stage_updated_at' => Carbon::now()->subMonths(4),
            ],

            // Stage: Lost
            [
                'title' => 'AeroGlobal Defense - Trial Run Evaluation',
                'description' => 'Pilot project concluded; client deferred budget to next fiscal budget cycle.',
                'lead_value' => 18500.00,
                'status' => 0, // Lost
                'lost_reason' => 'Budget deferred to next fiscal budget year.',
                'closed_at' => Carbon::now()->subDays(10),
                'expected_close_date' => Carbon::now()->subDays(10),
                'user_id' => $user->id,
                'person_id' => $persons['Marcus Brody']->id,
                'lead_source_id' => $sourceWeb->id,
                'lead_type_id' => $typeNew->id,
                'lead_pipeline_id' => $pipeline->id,
                'lead_pipeline_stage_id' => $stageLost->id,
                'stage_updated_at' => Carbon::now()->subDays(10),
            ],
            [
                'title' => 'BioSphere Healthcare - Medical Courier Tracking Module',
                'description' => 'Decided to build internal vehicle GPS hardware tracking rather than software workflow.',
                'lead_value' => 42000.00,
                'status' => 0, // Lost
                'lost_reason' => 'Requirements shifted to custom in-house hardware solution.',
                'closed_at' => Carbon::now()->subDays(18),
                'expected_close_date' => Carbon::now()->subDays(18),
                'user_id' => $user->id,
                'person_id' => $persons['Dr. Aris Thorne']->id,
                'lead_source_id' => $sourceInbound->id,
                'lead_type_id' => $typeExisting->id,
                'lead_pipeline_id' => $pipeline->id,
                'lead_pipeline_stage_id' => $stageLost->id,
                'stage_updated_at' => Carbon::now()->subDays(18),
            ],
        ];

        $createdLeads = [];
        foreach ($leadsData as $data) {
            $createdLeads[] = Lead::updateOrCreate(
                ['title' => $data['title']],
                $data
            );
        }

        // 5. Seed Stage Playbook Checklist Completions to show realistic progress pills!
        $allChecklists = StageChecklist::all()->groupBy('lead_pipeline_stage_id');

        foreach ($createdLeads as $lead) {
            $stageId = $lead->lead_pipeline_stage_id;
            if (isset($allChecklists[$stageId])) {
                $stageChecklists = $allChecklists[$stageId];
                // For BioSphere Healthcare & Hyperion AI (Negotiation), complete all checklists (3/3)
                if (str_contains($lead->title, 'BioSphere') || str_contains($lead->title, 'Hyperion')) {
                    foreach ($stageChecklists as $chk) {
                        StageChecklistCompletion::updateOrCreate([
                            'lead_id' => $lead->id,
                            'lead_stage_checklist_id' => $chk->id,
                        ], [
                            'is_completed' => true,
                            'completed_by_user_id' => $user->id,
                            'completed_at' => Carbon::now()->subDays(2),
                        ]);
                    }
                }
                // For Lumina Financial & CyberShield, complete 2 out of 3 checklists
                elseif (str_contains($lead->title, 'Lumina') || str_contains($lead->title, 'CyberShield')) {
                    foreach ($stageChecklists->take(2) as $chk) {
                        StageChecklistCompletion::updateOrCreate([
                            'lead_id' => $lead->id,
                            'lead_stage_checklist_id' => $chk->id,
                        ], [
                            'is_completed' => true,
                            'completed_by_user_id' => $user->id,
                            'completed_at' => Carbon::now()->subDays(1),
                        ]);
                    }
                }
                // For Apex Dynamics & Vertex Aerospace, complete 1 checklist
                elseif (str_contains($lead->title, 'Apex Dynamics') || str_contains($lead->title, 'Vertex')) {
                    if ($firstChk = $stageChecklists->first()) {
                        StageChecklistCompletion::updateOrCreate([
                            'lead_id' => $lead->id,
                            'lead_stage_checklist_id' => $firstChk->id,
                        ], [
                            'is_completed' => true,
                            'completed_by_user_id' => $user->id,
                            'completed_at' => Carbon::now()->subHours(8),
                        ]);
                    }
                }
            }
        }

        // 6. Seed Realistic Activities (Meetings, Calls, Notes)
        $activitiesData = [
            [
                'title' => 'Executive Architecture & Security Discovery',
                'type' => 'meeting',
                'comment' => 'Deep dive session with Marcus Brody on multi-region failover and GDPR data export compliance.',
                'schedule_from' => Carbon::now()->addDays(2)->setHour(14)->setMinute(0),
                'schedule_to' => Carbon::now()->addDays(2)->setHour(15)->setMinute(0),
                'is_done' => 0,
                'user_id' => $user->id,
                'lead_id' => $createdLeads[3]->id, // CloudScale
            ],
            [
                'title' => 'Commercial Pricing & Discount Negotiation Call',
                'type' => 'call',
                'comment' => 'Reviewed tiered volume discounts with Dr. Aris Thorne; approved 10% multi-site platform rebate.',
                'schedule_from' => Carbon::now()->subDays(2)->setHour(10)->setMinute(30),
                'schedule_to' => Carbon::now()->subDays(2)->setHour(11)->setMinute(15),
                'is_done' => 1,
                'user_id' => $user->id,
                'lead_id' => $createdLeads[9]->id, // BioSphere
            ],
            [
                'title' => 'Solution Demonstration: Visual Workflow Automation Canvas',
                'type' => 'meeting',
                'comment' => 'Walked Eleanor Vance and executive committee through the node-based workflow builder.',
                'schedule_from' => Carbon::now()->subDays(4)->setHour(16)->setMinute(0),
                'schedule_to' => Carbon::now()->subDays(4)->setHour(17)->setMinute(0),
                'is_done' => 1,
                'user_id' => $user->id,
                'lead_id' => $createdLeads[0]->id, // Apex Dynamics
            ],
            [
                'title' => 'Air-Gapped GovCloud Security & Audit Compliance Audit',
                'type' => 'meeting',
                'comment' => 'Met with CISO Lucas Sterling regarding DoD security baselines and immutable database audit logs.',
                'schedule_from' => Carbon::now()->addDays(1)->setHour(11)->setMinute(0),
                'schedule_to' => Carbon::now()->addDays(1)->setHour(12)->setMinute(30),
                'is_done' => 0,
                'user_id' => $user->id,
                'lead_id' => $createdLeads[10]->id, // CyberShield Defense
            ],
            [
                'title' => 'Fleet Telematics & WhatsApp Dispatch Integration Review',
                'type' => 'call',
                'comment' => 'Reviewed WhatsApp driver notification templates and delivery exception alert automations with Amara Chen.',
                'schedule_from' => Carbon::now()->subDays(1)->setHour(15)->setMinute(0),
                'schedule_to' => Carbon::now()->subDays(1)->setHour(15)->setMinute(45),
                'is_done' => 1,
                'user_id' => $user->id,
                'lead_id' => $createdLeads[4]->id, // Vanguard Logistics
            ],
            [
                'title' => 'Hyperion AI Copilot Integration Technical Q&A',
                'type' => 'meeting',
                'comment' => 'Discussed API endpoints for streaming call audio into the automated meeting summarizer engine with Dr. Vikram Patel.',
                'schedule_from' => Carbon::now()->addDays(4)->setHour(13)->setMinute(0),
                'schedule_to' => Carbon::now()->addDays(4)->setHour(14)->setMinute(0),
                'is_done' => 0,
                'user_id' => $user->id,
                'lead_id' => $createdLeads[11]->id, // Hyperion AI
            ],
        ];

        foreach ($activitiesData as $actData) {
            $leadId = $actData['lead_id'];
            unset($actData['lead_id']);

            $activity = Activity::firstOrCreate(['title' => $actData['title']], $actData);
            $activity->leads()->syncWithoutDetaching([$leadId]);
            $activity->participants()->firstOrCreate(['user_id' => $user->id]);

            $lead = Lead::find($leadId);
            if ($lead && $lead->person_id) {
                $activity->persons()->syncWithoutDetaching([$lead->person_id]);
            }
        }

        // Ensure all leads' activities are also linked to their contact persons
        foreach (Lead::with('activities')->get() as $l) {
            if ($l->person_id) {
                foreach ($l->activities as $act) {
                    $act->persons()->syncWithoutDetaching([$l->person_id]);
                }
            }
        }

        // 7. Seed Commercial Quotations with Line Items
        $quote1 = Quote::updateOrCreate([
            'subject' => 'Enterprise CRM Migration Proposal - Apex Dynamics',
        ], [
            'description' => 'Annual enterprise license, AI Copilot add-on, and mission-critical 24/7 SLA.',
            'billing_address' => [
                'address' => '500 Howard Street, Suite 400',
                'city' => 'San Francisco',
                'state' => 'CA',
                'country' => 'US',
                'postcode' => '94105',
            ],
            'shipping_address' => [
                'address' => '500 Howard Street, Suite 400',
                'city' => 'San Francisco',
                'state' => 'CA',
                'country' => 'US',
                'postcode' => '94105',
            ],
            'discount_percent' => 0,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'adjustment_amount' => 0,
            'sub_total' => 21500.00,
            'grand_total' => 21500.00,
            'expired_at' => Carbon::now()->addDays(30),
            'user_id' => $user->id,
            'person_id' => $persons['Eleanor Vance']->id,
        ]);

        QuoteItem::updateOrCreate([
            'quote_id' => $quote1->id,
            'product_id' => $products['NX-ENT-CORE']->id,
        ], [
            'sku' => 'NX-ENT-CORE',
            'name' => 'Nexora Enterprise Platform Core (Annual)',
            'quantity' => 1,
            'price' => 12000.00,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'total' => 12000.00,
        ]);

        QuoteItem::updateOrCreate([
            'quote_id' => $quote1->id,
            'product_id' => $products['NX-AI-COPILOT']->id,
        ], [
            'sku' => 'NX-AI-COPILOT',
            'name' => 'AI Sales Copilot & Deal Intelligence Suite',
            'quantity' => 1,
            'price' => 3500.00,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'total' => 3500.00,
        ]);

        QuoteItem::updateOrCreate([
            'quote_id' => $quote1->id,
            'product_id' => $products['NX-SLA-PREMIUM']->id,
        ], [
            'sku' => 'NX-SLA-PREMIUM',
            'name' => '24/7 Dedicated Mission-Critical SLA Support',
            'quantity' => 1,
            'price' => 6000.00,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'total' => 6000.00,
        ]);

        // Quote 2: CyberShield Defense High-Assurance GovCloud Proposal
        $quote2 = Quote::updateOrCreate([
            'subject' => 'High-Assurance GovCloud CRM Deployment - CyberShield Defense',
        ], [
            'description' => 'Enterprise core licenses, security audit trail pack, and multi-region high availability failover modules.',
            'billing_address' => [
                'address' => '1100 Constitution Ave NW',
                'city' => 'Washington',
                'state' => 'DC',
                'country' => 'US',
                'postcode' => '20004',
            ],
            'shipping_address' => [
                'address' => '1100 Constitution Ave NW',
                'city' => 'Washington',
                'state' => 'DC',
                'country' => 'US',
                'postcode' => '20004',
            ],
            'discount_percent' => 5,
            'discount_amount' => 1400.00,
            'tax_amount' => 0,
            'adjustment_amount' => 0,
            'sub_total' => 28000.00,
            'grand_total' => 26600.00,
            'expired_at' => Carbon::now()->addDays(20),
            'user_id' => $user->id,
            'person_id' => $persons['Lucas Sterling']->id,
        ]);

        QuoteItem::updateOrCreate([
            'quote_id' => $quote2->id,
            'product_id' => $products['NX-ENT-CORE']->id,
        ], [
            'sku' => 'NX-ENT-CORE',
            'name' => 'Nexora Enterprise Platform Core (Annual)',
            'quantity' => 1,
            'price' => 12000.00,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'total' => 12000.00,
        ]);

        QuoteItem::updateOrCreate([
            'quote_id' => $quote2->id,
            'product_id' => $products['NX-SEC-AUDIT']->id,
        ], [
            'sku' => 'NX-SEC-AUDIT',
            'name' => 'Enterprise Security & Audit Trail Pack',
            'quantity' => 2,
            'price' => 4500.00,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'total' => 9000.00,
        ]);

        QuoteItem::updateOrCreate([
            'quote_id' => $quote2->id,
            'product_id' => $products['NX-DR-FAILOVER']->id,
        ], [
            'sku' => 'NX-DR-FAILOVER',
            'name' => 'Multi-Region High Availability & Failover Module',
            'quantity' => 1,
            'price' => 5500.00,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'total' => 5500.00,
        ]);

        // Quote 3: CloudScale Technologies (Marcus Brody)
        $quote3 = Quote::updateOrCreate([
            'subject' => 'Multi-Cloud CRM Architecture & Telemetry - CloudScale Technologies',
        ], [
            'description' => 'Comprehensive multi-cloud deployment with real-time analytics and data retention pipelines.',
            'billing_address' => [
                'address' => '701 Brazos Street, Suite 500',
                'city' => 'Austin',
                'state' => 'TX',
                'country' => 'US',
                'postcode' => '78701',
            ],
            'shipping_address' => [
                'address' => '701 Brazos Street, Suite 500',
                'city' => 'Austin',
                'state' => 'TX',
                'country' => 'US',
                'postcode' => '78701',
            ],
            'discount_percent' => 10,
            'discount_amount' => 4200.00,
            'tax_amount' => 0,
            'adjustment_amount' => 0,
            'sub_total' => 42000.00,
            'grand_total' => 37800.00,
            'expired_at' => Carbon::now()->addDays(25),
            'user_id' => $user->id,
            'person_id' => $persons['Marcus Brody']->id,
        ]);

        QuoteItem::updateOrCreate([
            'quote_id' => $quote3->id,
            'product_id' => $products['NX-ENT-CORE']->id,
        ], [
            'sku' => 'NX-ENT-CORE',
            'name' => 'Nexora Enterprise Platform Core (Annual)',
            'quantity' => 2,
            'price' => 12000.00,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'total' => 24000.00,
        ]);

        QuoteItem::updateOrCreate([
            'quote_id' => $quote3->id,
            'product_id' => $products['NX-AI-COPILOT']->id,
        ], [
            'sku' => 'NX-AI-COPILOT',
            'name' => 'Nexora Autonomous AI Sales Copilot Add-on',
            'quantity' => 3,
            'price' => 6000.00,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'total' => 18000.00,
        ]);

        // Quote 4: Lumina Financial Systems (Sarah Jenkins)
        $quote4 = Quote::updateOrCreate([
            'subject' => 'Institutional FinTech CRM & Compliance Infrastructure - Lumina Financial',
        ], [
            'description' => 'Dedicated financial compliance audit suite, encrypted document vault, and customer portal integration.',
            'billing_address' => [
                'address' => '200 West Street, 28th Floor',
                'city' => 'New York',
                'state' => 'NY',
                'country' => 'US',
                'postcode' => '10282',
            ],
            'shipping_address' => [
                'address' => '200 West Street, 28th Floor',
                'city' => 'New York',
                'state' => 'NY',
                'country' => 'US',
                'postcode' => '10282',
            ],
            'discount_percent' => 0,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'adjustment_amount' => 0,
            'sub_total' => 58500.00,
            'grand_total' => 58500.00,
            'expired_at' => Carbon::now()->addDays(30),
            'user_id' => $user->id,
            'person_id' => $persons['Sarah Jenkins']->id,
        ]);

        QuoteItem::updateOrCreate([
            'quote_id' => $quote4->id,
            'product_id' => $products['NX-ENT-CORE']->id,
        ], [
            'sku' => 'NX-ENT-CORE',
            'name' => 'Nexora Enterprise Platform Core (Annual)',
            'quantity' => 3,
            'price' => 12000.00,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'total' => 36000.00,
        ]);

        QuoteItem::updateOrCreate([
            'quote_id' => $quote4->id,
            'product_id' => $products['NX-SEC-AUDIT']->id,
        ], [
            'sku' => 'NX-SEC-AUDIT',
            'name' => 'Enterprise Security & Audit Trail Pack',
            'quantity' => 5,
            'price' => 4500.00,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'total' => 22500.00,
        ]);

        // Quote 5: BioSphere Healthcare Logistics (Dr. Aris Thorne)
        $quote5 = Quote::updateOrCreate([
            'subject' => 'HIPAA Cold-Chain CRM & Telemetry Suite - BioSphere Healthcare',
        ], [
            'description' => 'Cold-chain shipment telemetry, real-time alert dispatch, and multi-tenant clinical account hierarchy.',
            'billing_address' => [
                'address' => '400 Technology Square, Suite 800',
                'city' => 'Cambridge',
                'state' => 'MA',
                'country' => 'US',
                'postcode' => '02139',
            ],
            'shipping_address' => [
                'address' => '400 Technology Square, Suite 800',
                'city' => 'Cambridge',
                'state' => 'MA',
                'country' => 'US',
                'postcode' => '02139',
            ],
            'discount_percent' => 5,
            'discount_amount' => 3200.00,
            'tax_amount' => 0,
            'adjustment_amount' => 0,
            'sub_total' => 64000.00,
            'grand_total' => 60800.00,
            'expired_at' => Carbon::now()->addDays(18),
            'user_id' => $user->id,
            'person_id' => $persons['Dr. Aris Thorne']->id,
        ]);

        QuoteItem::updateOrCreate([
            'quote_id' => $quote5->id,
            'product_id' => $products['NX-ENT-CORE']->id,
        ], [
            'sku' => 'NX-ENT-CORE',
            'name' => 'Nexora Enterprise Platform Core (Annual)',
            'quantity' => 4,
            'price' => 12000.00,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'total' => 48000.00,
        ]);

        QuoteItem::updateOrCreate([
            'quote_id' => $quote5->id,
            'product_id' => $products['NX-DR-FAILOVER']->id,
        ], [
            'sku' => 'NX-DR-FAILOVER',
            'name' => 'Multi-Region High Availability & Failover Module',
            'quantity' => 2,
            'price' => 5500.00,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'total' => 11000.00,
        ]);

        QuoteItem::updateOrCreate([
            'quote_id' => $quote5->id,
            'product_id' => $products['NX-INT-HUB']->id,
        ], [
            'sku' => 'NX-INT-HUB',
            'name' => 'Custom Webhook & OpenAPI Gateway License',
            'quantity' => 1,
            'price' => 5000.00,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'total' => 5000.00,
        ]);

        // Quote 6: Quantum Robotics Corp (Elena Rostova)
        $quote6 = Quote::updateOrCreate([
            'subject' => 'Robotics Industrial Sales Automation - Quantum Robotics',
        ], [
            'description' => 'Automated CPQ engine, multi-currency price books, and industrial partner channel integration.',
            'billing_address' => [
                'address' => '2201 6th Avenue',
                'city' => 'Seattle',
                'state' => 'WA',
                'country' => 'US',
                'postcode' => '98121',
            ],
            'shipping_address' => [
                'address' => '2201 6th Avenue',
                'city' => 'Seattle',
                'state' => 'WA',
                'country' => 'US',
                'postcode' => '98121',
            ],
            'discount_percent' => 0,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'adjustment_amount' => 0,
            'sub_total' => 38000.00,
            'grand_total' => 38000.00,
            'expired_at' => Carbon::now()->addDays(22),
            'user_id' => $user->id,
            'person_id' => $persons['Elena Rostova']->id,
        ]);

        QuoteItem::updateOrCreate([
            'quote_id' => $quote6->id,
            'product_id' => $products['NX-ENT-CORE']->id,
        ], [
            'sku' => 'NX-ENT-CORE',
            'name' => 'Nexora Enterprise Platform Core (Annual)',
            'quantity' => 2,
            'price' => 12000.00,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'total' => 24000.00,
        ]);

        QuoteItem::updateOrCreate([
            'quote_id' => $quote6->id,
            'product_id' => $products['NX-AI-COPILOT']->id,
        ], [
            'sku' => 'NX-AI-COPILOT',
            'name' => 'Nexora Autonomous AI Sales Copilot Add-on',
            'quantity' => 1,
            'price' => 6000.00,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'total' => 6000.00,
        ]);

        QuoteItem::updateOrCreate([
            'quote_id' => $quote6->id,
            'product_id' => $products['NX-WFL-AUTO']->id,
        ], [
            'sku' => 'NX-WFL-AUTO',
            'name' => 'Visual Workflow Automation Engine Pack',
            'quantity' => 2,
            'price' => 4000.00,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'total' => 8000.00,
        ]);

        // Quote 7: Hyperion AI Labs (Dr. Vikram Patel)
        $quote7 = Quote::updateOrCreate([
            'subject' => 'Enterprise AI Copilot Platform & Live Pipeline Engine - Hyperion AI',
        ], [
            'description' => 'Frontier LLM integrations, predictive deal scoring, and automated meeting action-item extractors.',
            'billing_address' => [
                'address' => '3000 Sand Hill Road, Building 4',
                'city' => 'Menlo Park',
                'state' => 'CA',
                'country' => 'US',
                'postcode' => '94025',
            ],
            'shipping_address' => [
                'address' => '3000 Sand Hill Road, Building 4',
                'city' => 'Menlo Park',
                'state' => 'CA',
                'country' => 'US',
                'postcode' => '94025',
            ],
            'discount_percent' => 5,
            'discount_amount' => 4250.00,
            'tax_amount' => 0,
            'adjustment_amount' => 0,
            'sub_total' => 85000.00,
            'grand_total' => 80750.00,
            'expired_at' => Carbon::now()->addDays(14),
            'user_id' => $user->id,
            'person_id' => $persons['Dr. Vikram Patel']->id,
        ]);

        QuoteItem::updateOrCreate([
            'quote_id' => $quote7->id,
            'product_id' => $products['NX-ENT-CORE']->id,
        ], [
            'sku' => 'NX-ENT-CORE',
            'name' => 'Nexora Enterprise Platform Core (Annual)',
            'quantity' => 5,
            'price' => 12000.00,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'total' => 60000.00,
        ]);

        QuoteItem::updateOrCreate([
            'quote_id' => $quote7->id,
            'product_id' => $products['NX-AI-COPILOT']->id,
        ], [
            'sku' => 'NX-AI-COPILOT',
            'name' => 'Nexora Autonomous AI Sales Copilot Add-on',
            'quantity' => 3,
            'price' => 6000.00,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'total' => 18000.00,
        ]);

        QuoteItem::updateOrCreate([
            'quote_id' => $quote7->id,
            'product_id' => $products['NX-INT-HUB']->id,
        ], [
            'sku' => 'NX-INT-HUB',
            'name' => 'Custom Webhook & OpenAPI Gateway License',
            'quantity' => 1,
            'price' => 7000.00,
            'discount_amount' => 0,
            'tax_amount' => 0,
            'total' => 7000.00,
        ]);

        // Enrich any older/unpopulated demo persons so every contact view in the CRM is complete
        $firstOrg = Organization::first();
        Person::whereNull('job_title')->orWhere('job_title', '')->get()->each(function ($p, $idx) use ($firstOrg) {
            $titles = ['Senior Sales Director', 'VP of Engineering', 'Principal Solutions Architect', 'Chief Information Officer'];
            $p->job_title = $titles[$idx % count($titles)];
            if (! $p->organization_id && $firstOrg) {
                $p->organization_id = $firstOrg->id;
            }
            if (empty($p->contact_numbers)) {
                $p->contact_numbers = [['value' => '+1 (555) 010-'.(2000 + $p->id), 'label' => 'work']];
            }
            $p->save();
        });
    }
}
