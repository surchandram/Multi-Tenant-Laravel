<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use SAAS\Domain\Documents\Actions\UpsertDocumentAction;
use SAAS\Domain\Documents\DataTransferObjects\DocumentData;

class DocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $documents = [
            [
                'title' => 'Work Authorization',
                'usable' => true,
                'is_editable' => false,
                'document_type_id' => \SAAS\Domain\Documents\Enums\DocumentType::WorkAuthorization->value,
                'body' => "This contract is made this date by and between, %company%, and %owner_name%. %owner_name% gives permission to %company% to proceed with its recommended service procedures in order to preserve, protect, and secure from further damage, at %job_address%. The liability of %company% will be limited to the scope of services authorized herein and in no event shall %company%, be liable for consequential damages of any kind.

                %company% shall bill all charges and/or costs to %owner_name% and, as a courtesy, a copy of the invoice along with all documents shall be provided to %insurance_company%. %owner_name% further authorizes and directs %insurance_company% to pay %company% directly, and to name %company% on any, and all, insurance drafts applicable to this loss. It is fully understood and agreed to by %owner_name% that any charges or costs for services which are not reimbursed by %insurance_company% are the sole responsibility of %owner_name% and are to be paid upon completion of work.

                A finance charge of 1.5% per month (minimum of $2.00), will be applied to any unpaid balance after thirty (30) days. In the event any legal proceedings must be instituted to recover the amount due, %company% shall be entitled to recover the cost of collection including reasonable attorney's fees.",
            ],
            [
                'title' => 'Certificate of Completion',
                'usable' => true,
                'is_editable' => false,
                'document_type_id' => \SAAS\Domain\Documents\Enums\DocumentType::WorkCompletion->value,
                'body' => 'The undersigned %owner_name%, hereinafter referred to as Owner, hereby certifies that all emergency cleaning and/or restoration services provided by %company%, hereinafter referred to as %company_name%, at the above mentioned property have been completed to his/her entire satisfaction.

                These services were necessitated by damages suffered on %date_of_loss%

                %owner_name% agrees that the services provided by %company% have been completed to satisfaction. Upon execution of this Certificate, %owner_name% and/or authorized representative, releases %company% from all liability, past, present and future, concerning the subject property for the scope of services rendered.',
            ],
            [
                'title' => 'Release from Liability',
                'usable' => true,
                'is_editable' => false,
                'document_type_id' => \SAAS\Domain\Documents\Enums\DocumentType::RealeaseFromLiability->value,
                'body' => '%company%, its agents and employees will not be held liable for items damaged during the cleaning and unpacking process at %job_address%. Furthermore, %company% will not be responsible to confirm the status of each object prior to the item being packed or cleaned.

                Although %company% strives to provide excellent service, unfortunately there will be situations in which there will be damage to or breakage of items. Damage or breakage shall not be covered for replacement by %company%, unless %company% is negligent.

                %owner_name% hereby acknowledge that during the cleaning and unpacking process and services performed at %job_address% by %company% items may be broken or damaged through no fault of %company%, its agents or employees.

                %company% shall not be liable for the breakage or damage of the items involved, unless %company% is negligent, and I agree to hold %company% harmless for such acts.',
            ],
            [
                'title' => 'Chemical Realease',
                'usable' => true,
                'is_editable' => false,
                'document_type_id' => \SAAS\Domain\Documents\Enums\DocumentType::ChemicalRealease->value,
                'body' => 'I, %owner_name% authorize the use of antimicrobial agents at the property located at %job_address%. %owner_name% understands that in the best judgment of %company%, with the facts presented at initial inspection, all affected materials should be treated with a commercial antimicrobial agent to help inhibit the growth of microorganisms during the drying process.  %owner_name% has received oral and written information regarding the antimicrobial agent and agrees that all wet materials should be treated with this product as part of the restoration process.  %owner_name% understands that it is beyond the expertise of %company% to determine if someone may be sensitive to its application and that %company% will not be held liable for its use. %owner_name% understands that any living beings (persons, or pets) should remain out of the home during the application of these products.',
            ],
        ];

        foreach ($documents as $key => $document) {
            $documentData = DocumentData::from($document);

            UpsertDocumentAction::execute($documentData);
        }
    }
}
