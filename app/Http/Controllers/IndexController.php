<?php

namespace App\Http\Controllers;

use App\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class IndexController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function knowledge()
    {
        return view('knowledge');
    }

    public function knowledgeDetail(Request $request)
    {
        if($request->id == 5){
            return view('metabolism');
        } elseif($request->id ==4){
            return view('placenta');
        }
        $array = array(
            1 => array('title' => 'Birthweight',
                'text' => array('There is unequivocal evidence that smoking and exposure to second-hand smoke cause decreased birthweight.',
                    'Findings also suggest that there is a significant dose–response relationships and a positive effect of smoking cessation prior to or during pregnancy.',
                    'Secondhand smoke exposure of non-smoking pregnant women is deleterious to the intrauterine growth of their fetuses. Secondhand smoke exposure affects birthweight and increases the risks of SGA (small for gestational age) and LBW (low birth weight) births.',
                    'The mechanisms underlying the effects of tobacco on fetal growth are not well understood and are likely to be multifactorial.',
                    'Smoking or nicotine alone causes transient reduction of uterine blood flow, while carbon monoxide in cigarette smoke can elicit hypoxemia.',
                    'Fetuses of smokers tend to have elevated hemoglobin and hematocrit, known responses to hypoxia.',
                    'Effects of smoking on the placenta may exacerbate fetal distress.',
                    'Smokeless tobacco use has also been associated with lower birthweight.'),
                '3d' => false
            ),
            2 => array('title' => 'Sudden Infant Death Syndrom (SIDS)',
                'text' => array('Evidence strongly supports a causative role of exposure to tobacco smoke in the etiology of SIDS',
                    'Studies consistently demonstrate a dose–response relationship between maternal smoking and risk of SIDS'
                ),
                '3d' => false
            ),
            3 => array('title' => 'Childhood obesity',
                'text' => array('Smoking at any time during pregnancy was associated with higher offspring BMI and total fat mass.',
                ),
                '3d' => false
            ),
//            4 => array('title' => 'Effects on the placenta',
//                'text' => array('Maternal smoking alters the blood flow to the placenta and changes the balance between proliferation and differentiation of the cytotrophoblast',
//                    'Changes seen in the placentas of smokers were present in less severe form in women exposed to secondhand smoke during pregnancy.',
//                    'Cadmium, a constituent of tobacco smoke known to accumulate in the placenta, has been shown to inhibit the activity of the enzyme 11-β-hydroxysteroid dehydrogenase type 2 (11-β-HSD2) as well as decrease 11-β-HSD2 mRNA and protein in cultured human trophoblast cells [49]. Reduction in 11-β-HSD2 activity in the placenta has been associated with decreased intrauterine growth',
//                    'Placental abruption, the premature separation of a normally implanted placenta before delivery, occurs in about 1% of pregnancies….maternal smoking has been associated with a 90% increase in risk of placental abruption (odds ratio 1.9 [95% CI 1.8–2.0])',
//                    'Maternal smoking has been associated with placenta previa, which is the implantation of the placenta over or near the internal os of the cervix. As labor approaches, partial detachment and severe vaginal bleeding may result.',
//                    'The odds ratios for increased risk of placenta previa with maternal smoking ranged from 2.6 to 4.4, despite controlling for confounders'
//                ),
//                '3d' => true
//            ),
//            5 => array('title' => 'Metabolism of Nicotine',
//                'text' => array('Maternal smoking alters the blood flow to the placenta and changes the balance between proliferation and differentiation of the cytotrophoblast',
//                    'Changes seen in the placentas of smokers were present in less severe form in women exposed to secondhand smoke during pregnancy.',
//                    'Cadmium, a constituent of tobacco smoke known to accumulate in the placenta, has been shown to inhibit the activity of the enzyme 11-β-hydroxysteroid dehydrogenase type 2 (11-β-HSD2) as well as decrease 11-β-HSD2 mRNA and protein in cultured human trophoblast cells [49]. Reduction in 11-β-HSD2 activity in the placenta has been associated with decreased intrauterine growth',
//                    'Placental abruption, the premature separation of a normally implanted placenta before delivery, occurs in about 1% of pregnancies….maternal smoking has been associated with a 90% increase in risk of placental abruption (odds ratio 1.9 [95% CI 1.8–2.0])',
//                    'Maternal smoking has been associated with placenta previa, which is the implantation of the placenta over or near the internal os of the cervix. As labor approaches, partial detachment and severe vaginal bleeding may result.',
//                    'The odds ratios for increased risk of placenta previa with maternal smoking ranged from 2.6 to 4.4, despite controlling for confounders'
//                ),
//                '3d' => true
//            ),
            6 => array('title' => 'Nicotine and Brain',
                'text' => array('Maternal smoking alters the blood flow to the placenta and changes the balance between proliferation and differentiation of the cytotrophoblast',
                    'Changes seen in the placentas of smokers were present in less severe form in women exposed to secondhand smoke during pregnancy.',
                    'Cadmium, a constituent of tobacco smoke known to accumulate in the placenta, has been shown to inhibit the activity of the enzyme 11-β-hydroxysteroid dehydrogenase type 2 (11-β-HSD2) as well as decrease 11-β-HSD2 mRNA and protein in cultured human trophoblast cells [49]. Reduction in 11-β-HSD2 activity in the placenta has been associated with decreased intrauterine growth',
                    'Placental abruption, the premature separation of a normally implanted placenta before delivery, occurs in about 1% of pregnancies….maternal smoking has been associated with a 90% increase in risk of placental abruption (odds ratio 1.9 [95% CI 1.8–2.0])',
                    'Maternal smoking has been associated with placenta previa, which is the implantation of the placenta over or near the internal os of the cervix. As labor approaches, partial detachment and severe vaginal bleeding may result.',
                    'The odds ratios for increased risk of placenta previa with maternal smoking ranged from 2.6 to 4.4, despite controlling for confounders'
                ),
                '3d' => true
            ),
        );

        return view('knowledge_detail', [
            'topic' => $array[$request->id],
        ]);

    }

    public function threed()
    {
        return view('smoke');
    }

    public function lung()
    {
        return view('lung');
    }

    public function concentration()
    {
        return view('concentration');
    }

    public function postContact(Request $request)
    {
        $name = $request->name;
        $phone = $request->phone;
        $email = $request->email;
        $subject = $request->subject;
        $mess = $request->message;
        Contact::create([
            'name' => $name,
            'phone' => $phone,
            'email' => $email,
            'subject' => $subject,
            'message' => $mess
        ]);

        $exception = 'sdf';
        Mail::send('mail', ['subject' => $subject, 'name' => $name, 'mess' => $mess, 'phone' => $phone, 'email' => $email], function ($message) {
            $message->to("harvey.nz@gmail.com")->cc('harvey.ho@auckland.ac.nz')->cc('tuananh191194@gmail.com')
                ->subject('New contact submission from 3d-fetus.org');
        });
        return view('welcome');
    }
}
