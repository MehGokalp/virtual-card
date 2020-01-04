package com.vendorbear.service.card;

import com.vendorbear.entitiy.Card;
import com.vendorbear.repository.CardRepository;
import org.springframework.stereotype.Service;

@Service
public class FindCardService extends AbstractCardService {
    public FindCardService(CardRepository cardRepository) {
        super(cardRepository);
    }

    public com.vendorbear.schema.Card find(String reference) {
        Card card = this.cardRepository.findByReference(reference);

        if (card == null) {
            return null;
        }

        com.vendorbear.schema.Card schema = new com.vendorbear.schema.Card();
        schema.setBalance(card.getBalance());
        schema.setReference(card.getReference());
        schema.setCvc(card.getCvc());
        schema.setCardNumber(card.getCardNumber());
        schema.setCurrency(card.getCurrency().getCode());
        schema.setActivationDate(card.getActivationDate());
        schema.setExpireDate(card.getExpireDate());

        return schema;
    }
}
