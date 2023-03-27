@extends('layouts.front')
@section('title')
   Terms & Conditions
@endsection
@section('css')
@endsection
@section('content')
    <div class="container text-justify mb-5">
        <div class="my-5 text-center">
            <a href="{{route('home')}}">
            <img class="lazyload img-fluid logo-img"
                    src="{{ URL::to('storage/app/public/Adminassets/image/logo-2.svg') }}"
                    data-srcset="{{ URL::to('storage/app/public/Adminassets/image/logo-2.svg') }}" alt="logo" />
            </a>
        </div>
        <h1 class="text-center my-5">Terms & Conditions</h1>
        <div class="terms-conditions-list">
            
            <h2> 1. Special Notices </h2>
            <p> 1.1 BK LIVE (SINGAPORE) PTE LTD (“BK LIVE”) agrees to provide a live streaming 
                network / platform of live stream content or other content uploaded directly by users (User 
                Generated Content – “UGC”) utilizing the internet and cellular networks based services 
                (hereafter "Web Services") in accordance with the provisions of this Agreement and any 
                terms of use that are periodically issued. To obtain these Web Services, the service user 
                (hereafter the "User") shall agree to the provisions of this Agreement in its entirety and 
                complete the registration process as indicated on the page. By clicking on "Sign Up" during 
                the registration process, the User wholly agrees to all provisions in the items of this 
                Agreement. 
                By using the Web Services under this Agreement, User hereby declares that: 
                (i) User is of the sufficient legal age (according to the prevailing regulations) and have the full
                legal capacity and are not prohibited to enter into and conclude a binding agreement, or 
                (ii) you have obtained the consent from your parents or guardian to use the Web Services 
                and to be bound by this Agreement. 
                You also declare that the information you provide in the registration process is always 
                correct, true, up to date and accurate. BK LIVE has the right to amend or modify this 
                Agreement as it may consider necessary without further notice to User, including by way of 
                announcing the amendment to the Web Services and the User agrees that by continuing to 
                use the Web Services after the amendment or modification, the User agrees to be bound by 
                the amended terms and conditions which has been modified. For the purposes of this 
                Agreement, BK LIVE and the User shall be jointly referred to as the “Parties” and any one of 
                them as a “Party”.
            </p>
            <p>
                1.2 After the User is successfully registered, BK LIVE will assign each user a user account, 
                the safekeeping of which shall be the responsibility of the User. The User shall bear full legal
                liability for all behaviour and activities conducted through their user account. The User shall 
                indemnify and hold BK LIVE free and harmless from any claims and/or lawsuits from any 
                third parties arising out of the User’s use or unlawful use of the Web Services through its 
                user account.
            </p>    
            <h2> 2. Web Services Content</h2>
            <p>
                2.1 The actual content of the Web Services is provided by BK LIVE based on the situation, 
                e.g., a live video broadcast, video on demand, music streaming, searches, networking etc.
            </p>
            <p>
                2.2 Some of the Web Services provided by BK LIVE require payment. When the User uses 
                such paid-for services, they will be required to pay the relevant charges to BK LIVE. For 
                paid-for Web Services, BK LIVE will give the User explicit notice in advance. The User can 
                only access such services if he/she confirms, as prompted, that he/she agrees to and pay 
                the relevant charges. The User acknowledges and agrees that if the User chooses to decline
                to pay the relevant charges, BK LIVE has the right to not provide such paid-for Web Services
                to the User.
            </p>
            <p>
                2.3 The User understands that BK LIVE merely provides the relevant Web Services, and that
                the User is solely responsible for his/her own required equipment (such as PC, cell phone or 
                any other devices used for connecting to the internet or cellular network) relevant to these 
                Web Services, as well as the necessary costs (such as telephone or internet charges for 
                internet connection and cell phone charges for cellular network usage) thereof.
            </p>
            <h2> 3. Modification, Suspension, Termination or Restriction of Service</h2>
            <p>
                3.1 In consideration of the unique nature of Web Services, the User acknowledges and 
                agrees that BK LIVE has the right, at its sole discretions, to modify, suspend or terminate 
                part or all of these Web Services (including those requiring payment) at any time and from 
                time to time. BK LIVE may also impose limits on certain features and services or restrict the 
                User’s access to part or all of these Web Services. If the modified, suspended, terminated or
                restricted App Service is a free service, BK LIVE is not obligated to notify the User and shall 
                not have any liability in whatsoever forms to the User or any third party. If the modified, 
                suspended or terminated App Service is a paid-for service, BK LIVE shall notify the User in 
                advance of any modification, suspension or termination, and should provide affected users 
                with an alternative paid-for service of equivalent value.
             </p>
             <p>
                3.2 The User understands that BK LIVE needs to perform scheduled or unscheduled repairs 
                and maintenance on the platform providing the Web Services (such as the website or 
                cellular network, etc.) and the relevant equipment. If such situations cause an interruption of 
                paid-for Web Services for a reasonable duration, BK LIVE shall not bear any liability to the 
                User and/or to any third parties. However, BK LIVE shall provide as much advance notice as
                possible.
             </p>
             <p>
                3.3 BK LIVE has the right to suspend, terminate or restrict provision of the Web Services 
                under this Agreement at any time and is not obligated to bear any liability to the User or any 
                third party, if any of the following events occur:
             </p>
             <p>
                3.3.1 Personal information provided by the user is false;
                </p>
                        <p>
                3.3.2 The User violates the terms of use stipulated within this Agreement;
                </p>
                        <p>
                3.3.3 The User does not make a payment to BK LIVE, as stipulated, to cover the relevant 
                service fees when using paid-for Web Services.
                </p>
                        <p>
                3.4 If the User's registered account for a free App Service is inactive for 90 consecutive 
                days, or the User's registered account for a paid-for Web Services is inactive for 180 
                consecutive days following expiration of the subscription period, then BK LIVE has the right 
                to delete the account and discontinue the provision of relevant Web Services to the User.
                </p>
                        <p>
                3.5 If the User's registered free account name violates any laws and regulations or national 
                policies, or if it infringes upon the legal rights and interests of any third party, BK LIVE retains
                the right to revoke the account name.</p>

            <h2> 4. Terms of Use</h2>
            <p>
                4.1 When applying to use BK LIVE's Web Services, the User must provide accurate 
                personal information and promptly update the information if any changes occur, and upon 
                request from BK LIVE, provide evidence to verify accuracy of the information given.
                </p>
                        <p>
                4.2 The User shall not transfer or loan his account or password to others. The User shall 
                immediately notify BK LIVE if he discovers unlawful use of his account by others. BK LIVE 
                shall not bear any liability, in whatsoever forms, if hacking or user negligence results in the 
                unlawful use by others of the User's account or password.
                </p>
                        <p>
                4.3 The User agrees that BK LIVE has the right to, when providing Web Services, place any 
                type of commercial advertisement in any form or other types of commercial information 
                (including, but not limited to, the placement of advertisements on any page of BK LIVE 
                website). The User also agrees to receive promotional or other relevant commercial 
                information from BK LIVE via email or other methods.
                </p>
                        <p>
                4.4 By using and/or uploading any content through BK LIVE Web Services (including but not 
                limited to forums, Facebook, Twitter, comments or personal microblogs) to publicly 
                accessible areas of BK LIVE website, the User grants to BK LIVE the permission, free, 
                permanent, irrevocable, non-exclusive and fully sub-licensable rights and license, without 
                any territorial or time limitations and without requiring any approvals and/or compensations, 
                to use, copy, modify, adapt, publish, translate, edit, dispose, create derivate works of, 
                distribute, perform and publicly display such content (in whole or in part), and/or incorporate 
                such content into existing or future forms of work, media or technology.
                </p>
                        <p>
                4.5 While using the BK LIVE Web Services, the User must abide by the following:
                4.5.1 The User shall comply with all applicable laws and regulations in Singapore and 
                Thailand;
                </p>
                        <p>
                4.5.2 The User shall comply with all agreements, stipulations and procedures applicable to 
                the Web Services;
                </p>
                        <p>
                4.5.3 The User shall not use the Web Services system for any unlawful purpose which is in 
                violation of the prevailing laws, decency and public policy;
                </p>
                        <p>
                4.5.4 The User shall not, in any shape or form, use BK LIVE Web Services to infringe upon 
                the commercial interests of BK LIVE, including but not limited to the posting of commercial 
                advertisements without the express permission of BK LIVE Community;
                </p>
                        <p>
                4.5.5 The User shall not use BK LIVE Web Services system to engage in behaviour that may
                adversely impact the normal operation of the internet or cellular network;
                </p>
                        <p>
                4.5.6 The User shall not use Web Services provided by BK LIVE to upload, display or 
                distribute any false, harassing, harmful, abusive, threatening, vulgar or obscene messages 
                or information, or any other type of unlawful messages or information;
                </p>
                        <p>
                4.5.7 The User shall not infringe upon the patents, copyrights, trademarks, right to reputation
                or any other legal rights and interests of any third party;
            </p> 
            <p>
                4.5.8 The User shall not use BK LIVE Web Services system to engage in any behaviour 
                detrimental to the interests of BK LIVE;
            </p>
            <p>
                4.6 BK LIVE has the right to review and monitor the User's usage of BK LIVE Web Services 
                (including, but not limited to, review of content stored by the User on the BK LIVE website). If
                BK LIVE, at its sole discretions, reasonably consider that the User violates any of the 
                aforementioned stipulations when using the Web Services, BK LIVE or its authorized agent 
                has the right to request the User to rectify the situation or to directly take all necessary 
                measures (including, but not limited to, modifying or deleting the content posted by the User,
                or suspension or termination of the User's rights to use the Web Services) to mitigate the 
                impact of the User's improper conduct without requiring any approval from the User.
            </p>
            <p>
                4.7 Any disclaimers, notifications or cautions regarding the usage of particular BK LIVE Web 
                Services, which are issued through various methods (including, but not limited to, webpage 
                announcements, emails and in-app notifications) shall be deemed to form part of this 
                Agreement. Usage of such Web Services shall be deemed to be a confirmation of the User's
                acceptance of the content of such disclaimers, notifications and cautions.
            </p>
            <p>
                4.8 BK LIVE will limit access to information about the User to employees who we believe 
                reasonably need to come into contact with that information to provide products or services to
                the User or in order to do their jobs.
            </p>
            <h2> 5. Intellectual Property Rights </h2>
            <p>
                5.1 All text, data, images, graphics, audio and/or video information and other materials within
                the Web Services provided by BK LIVE are property of BK LIVE are protected by copyright, 
                trademark and/or other property rights laws. Nothing in this Agreement shall be construed as
                conferring any license of any intellectual property rights or such materials by BK LIVE to the 
                User. The User is prohibited from copying, displaying, downloading, modifying, reproducing 
                or creating any derivative works of such materials, directly or indirectly published, performed,
                rewritten or republished for performance or distribution purposes, or otherwise used for 
                commercial purposes without prior written consent from BK LIVE. The entirety or any part of 
                such information may only be stored on a computer for private and non-commercial use. In 
                further consideration of the unique nature of the Web Services, BK LIVE shall not bear any 
                liability for any loss or damage incurred by the User by using the Web Services, any 
                compensation, in any form, to the User or any third party for delays, inaccuracies, errors or 
                omissions, interruption or defect arising from the production, the operation, transmission, 
                transfer or submission, communications-line failure, theft or destruction of all or part of the 
                aforementioned information, nor for any losses or damages arising from, or caused by, such 
                inaccuracies, errors or omissions or any unauthorized access of the Web Services.
                5.2 Any intellectual property rights of any software (including, but not limited to, any images, 
                photos, animations, video recordings, audio recordings, music, text, add-on programs and 
                supplementary material) belonging to any third party used by BK LIVE in the provision of 
                Web Services belong to such third party copyright holder. The User may not reverse 
                engineer, decompile or disassemble such software without the prior permission of the 
                copyright holder.
                5.3 By providing live-feed content or by uploading other content including but not limited to 
                files, photographs, links, texts and images, User agrees to give BK LIVE (including and all 
                other users of the Web Services) an irrevocable non-exclusive royalty-free rights to use the 
                UGC or any other content and their selection and arrangement for any purpose including 
                publication, display, modification, and creation of derivative works.
            </p>
            <h2> 6. Privacy Protection </h2>
            <p>
                6.1 The protection of user privacy is a fundamental policy of BK LIVE. BK LIVE guarantees 
                that it will not publicly disclose or provide a third party with an individual user's registered 
                information or non-public content, which is stored in BK LIVE during the use of Web 
                Services. However, the following circumstances are excluded:
            </p>
            <p>    
                6.1.1 When prior express authorization is obtained from the User;
            </p>
            <p>     
                6.1.2 When and as required by applicable laws and regulations; 
            </p>
            <p>    
                6.1.3 When and as required by relevant competent authorities of the government; 
            </p>
            <p>    
                6.1.4 When it is necessary to safeguard the public interest; 
            </p>
            <p>
                6.1.5 When it is necessary to safeguard the legal rights and interests of BK LIVE
            </p>
            <p>
                6.2 BK LIVE may collaborate with a third party to provide the User with relevant Web 
                Services. In this scenario, BK LIVE has the right to share the User's registered information 
                with a third party, if the third party agrees to bear responsibility for providing privacy 
                protection equivalent to that of BK LIVE.
            </p>
            <p>    
                6.3 Under the condition that no private information of an individual user is disclosed, BK 
                LIVE has the right to analyze the entire user database and utilize the database for 
                commercial purposes.
            </p>
            <p>    
                6.4 The User acknowledges and agrees that the User may, directly or indirectly, provide any 
                of its personal information through its use of the Web Services and as provided under this 
                agreement. For the purposes of this article, the User hereby agrees and consents to the use 
                of the User’s personal information by BK LIVE, and such shall be considered as the consent 
                as stipulated under the prevailing Singapore and Thailand laws.
            </p>

            <h2> 7. Disclaimers </h2>
            <p>
                7.1 The User expressly agrees that he/she shall be fully responsible for any risks involved in 
                using BK LIVE Web Services. The User shall also be responsible for any and all 
                consequences arising from the Use of BK LIVE Web Services, and BK LIVE shall not bear 
                any liability to the User.
            </p>
            <p>    
                7.2 Under no circumstance does the BK LIVE guarantee that the Web Services will satisfy 
                the User's requirements, or guarantee that the Web Services will be uninterrupted. The 
                timeliness, security and accuracy of the Web Services are also not guaranteed. The User 
                acknowledges and agrees that the Web Services is provided by BK LIVE on an “as is” basis.
                BK LIVE make no representations or warranties of any kind express or implied as to the 
                operation and the providing of such Web Services or any part thereof. BK LIVE shall not be 
                liable in any way for the quality, timeliness, accuracy or completeness of the Web Services 
                and shall not be responsible for any consequences which may arise from the User’s use of 
                such Web Services.
            </p>
            <p>    
                7.3 BK LIVE does not guarantee the accuracy and integrity of any external links that may be 
                accessible by using the Web Services and/or any external links that have been placed for 
                the convenience of the User. BK LIVE shall not be responsible for the content of any linked 
                site or any link contained in a linked site, and BK LIVE shall not be held responsible or liable,
                directly or indirectly, for any loss or damage in connection with the use of the Web Services 
                by the User. Moreover, BK LIVE shall not bear any responsibility for the content of any 
                webpage that the User is directed via an external link that is not under the control of BK 
                LIVE.
            </p>
            <p>    
                7.4 BK LIVE shall not bear any liability for the interruption of or other inadequacies in the 
                Web Services caused by circumstances of force majeure, or that are otherwise beyond the 
                control of BK LIVE. However, as far as possible, BK LIVE shall reasonably attempt to 
                minimize the resulting losses of and impact upon the User. 
                The User agrees that BK LIVE shall not bear any liability for any losses arising from 
                inadequacies in the quality of the following products or services provided by the BK LIVE:
            </p>
            <p>    
                7.4.1 Web Services provided to the User free of charge;
            </p>
            <p>    
                7.4.2 Any complimentary products or services offered to the User;
            </p>
            <h2> 8. Compensation </h2>
            <p>
                8.1 The User agrees to safeguard and maintain the interests of other users. If the User 
                violates the relevant laws and regulations, or any of the provisions of this Agreement, and in 
                doing so causes damages to BK LIVE or any other third party, the User agrees to bear full 
                responsibility for compensation of any damages caused.
            </p>
            <h2> 9. Changes to the Agreement </h2>
            <p>
                9.1 BK LIVE has the right to make changes at any time to any provision of this Agreement. 
                Once the contents of this Agreement have been modified, BK LIVE will publish the contents 
                of the modified Agreement directly on the BK LIVE website. This announcement shall be 
                deemed to be a confirmation that the BK LIVE has notified users of the changes. BK LIVE 
                may also inform users of the details of the changes through other appropriate methods.
            </p>
            <p>    
                9.2 The User has the right to discontinue use of the Web Services if they do not agree to the 
                changes made by BK LIVE to relevant provisions of this Agreement. Continued use of the 
                Web Services shall be deemed as an acceptance of such changes.
            </p>
            <h2> 10. Delivery of Notifications </h2>
            <p>
                10.1 Under the terms of this Agreement, all notifications sent to users by BK LIVE may be 
                delivered via a webpage announcement, email, text message or post; such notifications shall
                be deemed to have been received by the recipient on the date sent.
            </p>
            <p>    
                10.2 Notifications from the User to BK LIVE should be sent to the contact address, email 
                address or other contact details officially issued by BK LIVE.
            </p>
            <h2> 11. Other Terms </h2>
            <p>
                11.1 This Agreement constitutes the entire agreement of agreed items and other relevant 
                matters between both parties. Other than as stipulated by this Agreement, no other rights 
                are vested in either Party to this Agreement.
            </p>
            <p>    
                11.2 If any provision of this Agreement is rendered void or unenforceable, in whole or in part,
                for any reason, the remaining provisions of this Agreement shall remain valid and binding.
            </p>
            <p>    
                11.3 The headings within this Agreement have been set for the sake of convenience, and 
                shall be disregarded in the interpretation of this Agreement.
            </p>
        </div>
    </div>
@endsection

@section('js')

@endsection
