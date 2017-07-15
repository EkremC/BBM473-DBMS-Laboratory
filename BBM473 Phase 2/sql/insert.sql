exec PERMISSION_INSERT('insert', 'insert permission');

exec PERMISSION_INSERT('delete', 'delete permission');

exec ROLE_INSERT('superadmin', 'user that has all permissions');

exec SYSTEMUSER_INSERT('EkremC.', 'qwe', 'Ekrem', 'Candemir', 'middle-east', 1, 1, 'Turkey', 'Ankara', '5551112233');

exec SYSTEMUSER_INSERT('Luo', 'abc', 'Berk', 'Özata', 'middle-east', 1, 1, 'Turkey', 'Ankara', '5553332211');




exec COMMERCIALUSER_INSERT('lsilk', '123abc', 'Loren', 'Silk', 'US', 1, '6601457526243550', '395', '7607 Birch Hill Lane Silver Spring, MD 20901', '2018');

exec COMMERCIALUSER_INSERT('abera', '234lhkh', 'Anderson', 'Bera', 'US', 0, '7192372032650222', '574', '535 Kent Drive Waterford, MI 48329', '2019');

exec COMMERCIALUSER_INSERT('wveit', 'asdf89080', 'Willodean', 'Veit', 'US', 0, '2194838460529533', '801', '5884 Border St. Ottumwa, IA 52501', '2022');

exec COMMERCIALUSER_INSERT('sjohn', '098gdfklgj', 'Shayne', 'John', 'US', 1, '7280382664473267', '134', '454 Grove Dr. Lilburn, GA 30047', '2021');

exec COMMERCIALUSER_INSERT('arotter', 'hrty234', 'Ardella', 'Rotter', 'US', 0, '4821674999754434', '923', '7358 Rose Lane Wenatchee, WA 98801', '2019');

exec COMMERCIALUSER_INSERT('efrink', 'uoı5234', 'Emmanuel', 'Frink', 'US', 0, '2362272361045188', '256', '4 Greystone Drive South Bend, IN 46614', '2023');

exec COMMERCIALUSER_INSERT('mbeachy', '03mh23j4m', 'Maia', 'Beachy', 'US', 1, '9981318855815644', '972', '470 Southampton Ave. Revere, MA 02151', '2022');

exec COMMERCIALUSER_INSERT('tcurtiss', 'asdf879as', 'Thomasena', 'Curtiss', 'US', 1, '6734948615614911', '358', '994 Pumpkin Hill Street Hyattsville, MD 20782', '2018');

exec COMMERCIALUSER_INSERT('ecoursey', '4kjsd9djg', 'Elyse', 'Coursey', 'US', 1, '6110897965453800', '985', '9611 Chestnut Street Phillipsburg, NJ 08865', '2024');

exec COMMERCIALUSER_INSERT('mkreiger', '098safasn84', 'Maximina', 'Kreiger', 'US', 0, '3654107372640169', '519', '99 Fairway Drive Shelton, CT 06484', '2020');





exec AUTHOR_INSERT('J.R.R Tolkien', 'John Ronald Reuel Tolkien, CBE, was an English writer, poet, WWI veteran (a First Lieutenant in the Lancashire Fusiliers, British Army), philologist, and university professor, best known as the author of the high fantasy classic works The Hobbit and The Lord of the Rings .', 'tolkien.jpg', 1, 1, sysdate, sysdate);

exec AUTHOR_INSERT('George Orwell', 'Eric Arthur Blair, better known by his pen name George Orwell, was an English author and journalist. His work is marked by keen intelligence and wit, a profound awareness of social injustice, an intense opposition to totalitarianism, a passion for clarity in language, and a belief in democratic socialism.', 'orwell.jpg', 1, 1, sysdate, sysdate);

exec AUTHOR_INSERT('George R.R. Martin', 'George R.R. Martin was born September 20, 1948, in Bayonne, New Jersey. His father was Raymond Collins Martin, a longshoreman, and his mother was Margaret Brady Martin. He has two sisters, Darleen Martin Lapinski and Janet Martin Patten. ', 'rrmartin.jpg', 1, 1, sysdate, sysdate);

exec AUTHOR_INSERT('Stephen King', 'Stephen Edwin King (born September 21, 1947) is an American author of horror, supernatural fiction, suspense, science fiction, and fantasy. His books have sold more than 350 million copies, many of which have been adapted into feature films, miniseries, television shows, and comic books.', 'king.jpg', 1, 1, sysdate, sysdate);

exec AUTHOR_INSERT('Carl Sagan', 'in 1934, scientist Carl Sagan was born in Brooklyn, N.Y. After earning bachelor and master''s degrees at Cornell, Sagan earned a double doctorate at the University of Chicago in 1960. He became professor of astronomy and space science and director of the Laboratory for Planetary Studies at Cornell University, and co-founder of the Planetary Society.', 'carlsagan.jpg', 2, 2, sysdate, sysdate);

exec AUTHOR_INSERT('Franz Kafka', 'Franz Kafka was one of the major fiction writers of the 20th century. He was born to a middle-class German-speaking Jewish family in Prague, Bohemia (presently the Czech Republic), Austria–Hungary. His unique body of writing—much of which is incomplete and which was mainly published posthumously—is considered to be among the most ', 'franzkafka.jpg', 2, 2, sysdate, sysdate);

exec AUTHOR_INSERT('Gabriel García Márquez', 'Gabriel José de la Concordia Garcí­a Márquez was a Colombian novelist, short-story writer, screenwriter and journalist. Garcí­a Márquez, familiarly known as "Gabo" in his native country, was considered one of the most significant authors of the 20th century. In 1982, he was awarded the Nobel Prize in Literature.', 'garcia.jpg', 1, 1, sysdate, sysdate);

exec AUTHOR_INSERT('Stephen Hawking', 'Stephen William Hawking was born on 8 January 1942 in Oxford, England. His parents'' house was in north London, but during the second world war Oxford was considered a safer place to have babies. When he was eight, his family moved to St Albans, a town about 20 miles north of London.', 'hawking.jpg', 1, 1, sysdate, sysdate);

exec AUTHOR_INSERT('Leonard Mlodinow', 'Leonard Mlodinow is a physicist and author.Mlodinow was born in Chicago, Illinois, in 1959, of parents who were both Holocaust survivors. His father, who spent more than a year in the Buchenwald death camp, had been a leader in the Jewish resistance under Nazi rule in his hometown of Częstochowa, Poland. As a child, Mlodinow was interested in both mathematics and chemistry, and while in high school was tutored in organic chemistry by a professor from the University of Illinois.', 'leonard.jpg', 2, 2, sysdate, sysdate);

exec AUTHOR_INSERT('Fyodor M. Dostoyevsky', 'Dostoevsky, was a Russian novelist, journalist, and short-story writer whose psychological penetration into the human soul had a profound influence on the 20th century novel.', 'dostoyevski.jpg', 1, 1, sysdate, sysdate);




exec CATEGORY_INSERT('FANTASTIC', 1, 1, SYSDATE,SYSDATE);

exec CATEGORY_INSERT('SCIENCE', 2, 2, SYSDATE, SYSDATE);

exec CATEGORY_INSERT('FICTION', 1, 1, SYSDATE, SYSDATE);

exec CATEGORY_INSERT('NON-FICTION', 1, 1, SYSDATE, SYSDATE);

exec CATEGORY_INSERT('NON-FANTASTIC', 1, 1, SYSDATE, SYSDATE);

exec CATEGORY_INSERT('HORROR', 1, 1, SYSDATE, SYSDATE);

exec CATEGORY_INSERT('CLASSIC', 1, 1, SYSDATE, SYSDATE);

exec CATEGORY_INSERT('SCIENCE-FICTION', 1, 1, SYSDATE, SYSDATE);

exec CATEGORY_INSERT('FANTASY', 1, 1, SYSDATE, SYSDATE);



exec CATEGORYINHERITANCE_INSERT(2, 8, 1, 1, SYSDATE, SYSDATE);

exec CATEGORYINHERITANCE_INSERT(3, 8, 1, 1, SYSDATE, SYSDATE);





exec BOOK_INSERT('The Two Towers','The Fellowship was scattered. Some were bracing hopelessly for war against the ancient evil of Sauron. Some were contending with the treachery of the wizard Saruman. Only Frodo and Sam were left to take the accursed Ring of Power to be destroyed in Mordor–the dark Kingdom where Sauron was supreme.','twotowers.jpg', 2, 2, sysdate,sysdate);

exec BOOK_INSERT('The Shining', 'Jack Torrance''s new job at the Overlook Hotel is the perfect chance for a fresh start. As the off-season caretaker at the atmospheric old hotel, he''ll have plenty of time to spend reconnecting with his family and working on his writing. But as the harsh winter weather sets in, the idyllic location feels ever more remote...and more sinister. And the only one to notice the strange and terrible forces gathering around the Overlook is Danny Torrance, a uniquely gifted five-year-old.', 'shining.jpg', 1, 1, sysdate, sysdate);

exec BOOK_INSERT('1984', 'The year 1984 has come and gone, but George Orwell''s prophetic, nightmarish vision in 1949 of the world we were becoming is timelier than ever. 1984 is still the great modern classic of "negative utopia" -a startlingly original and haunting novel that creates an imaginary world that is completely convincing, from the first sentence to the last four words. No one can deny the novel''s hold on the imaginations of whole generations, or the power of its admonitions -a power that seems to grow, not lessen, with the passage of time.', '1984.jpg', 2, 2, sysdate, sysdate);

exec BOOK_INSERT('Animal Farm', 'Animal Farm is Orwell''s classic satire of the Russian Revolution -- an account of the bold struggle, initiated by the animals, that transforms Mr. Jones''s Manor Farm into Animal Farm--a wholly democratic society built on the credo that All Animals Are Created Equal. But are they?', 'animalfarm.jpg', 2, 2, sysdate, sysdate);

exec BOOK_INSERT('Cosmos', 'Cosmos has 13 heavily illustrated chapters, corresponding to the 13 episodes of the Cosmos television series. In the book, Sagan explores 15 billion years of cosmic evolution and the development of science and civilization. Cosmos traces the origins of knowledge and the scientific method, mixing science and philosophy, and speculates to the future of science.', 'cosmos.jpg', 1, 1, sysdate, sysdate);

exec BOOK_INSERT('The Metamorphosis', 'As Gregor Samsa awoke one morning from uneasy dreams he found himself transformed in his bed into a gigantic insect. He was laying on his hard, as it were armor-plated, back and when he lifted his head a little he could see his domelike brown belly divided into stiff arched segments on top of which the bed quilt could hardly keep in position and was about to slide off completely.', 'metamorphosis.jpg', 2, 2, sysdate, sysdate);

exec BOOK_INSERT('A Game of Thrones', 'Summers span decades. Winter can last a lifetime. And the struggle for the Iron Throne has begun. As Warden of the north, Lord Eddard Stark counts it a curse when King Robert bestows on him the office of the Hand. His honour weighs him down at court where a true man does what he will, not what he must … and a dead enemy is a thing of beauty.', 'gameofthrones.jpg', 2, 2, sysdate, sysdate);

exec BOOK_INSERT('One Hundred Years of Solitude', 'The novel tells the story of the rise and fall of the mythical town of Macondo through the history of the family. It is a rich and brilliant chronicle of life and death, and the tragicomedy of humankind. In the noble, ridiculous, beautiful, and tawdry story of the family, one sees all of humanity, just as in the history, myths, growth, and decay of Macondo, one sees all of Latin America.', 'onehundred.jpg', 1, 1, sysdate, sysdate);

exec BOOK_INSERT('A Briefer History of Time', 'Stephen Hawking’s worldwide bestseller A Brief History of Time remains a landmark volume in scientific writing. But for readers who have asked for a more accessible formulation of its key concepts—the nature of space and time, the role of God in creation, and the history and future of the universe—A Briefer History of Time is Professor Hawking’s response.', 'briefer.jpg', 2, 2, sysdate, sysdate);

exec BOOK_INSERT('The Brothers Karamazov', 'The Brothers Karamazov is a passionate philosophical novel set in 19th century Russia, that enters deeply into the ethical debates of God, free will, and morality. It is a spiritual drama of moral struggles concerning faith, doubt, and reason, set against a modernizing Russia.', 'karamazov.jpg', 1, 1, sysdate, sysdate);




exec BOOKAUTHOR_INSERT(1, 1, 1, 1, SYSDATE, SYSDATE);

exec BOOKAUTHOR_INSERT(2, 4, 1, 1, SYSDATE, SYSDATE);

exec BOOKAUTHOR_INSERT(3, 2, 1, 1, SYSDATE, SYSDATE);

exec BOOKAUTHOR_INSERT(4, 2, 1, 1, SYSDATE, SYSDATE);

exec BOOKAUTHOR_INSERT(5, 5, 1, 1, SYSDATE, SYSDATE);

exec BOOKAUTHOR_INSERT(6, 6, 1, 1, SYSDATE, SYSDATE);

exec BOOKAUTHOR_INSERT(7, 3, 1, 1, SYSDATE, SYSDATE);

exec BOOKAUTHOR_INSERT(8, 7, 1, 1, SYSDATE, SYSDATE);

exec BOOKAUTHOR_INSERT(9, 8, 1, 1, SYSDATE, SYSDATE);

exec BOOKAUTHOR_INSERT(9, 9, 2, 2, SYSDATE, SYSDATE);

exec BOOKAUTHOR_INSERT(10, 10, 2, 2, SYSDATE, SYSDATE);




--the two towers: fantastic, fiction
exec BOOKCATEGORY_INSERT(1, 1, 1, 1, SYSDATE, SYSDATE);

exec BOOKCATEGORY_INSERT(1, 3, 1, 1, SYSDATE, SYSDATE);

--the shining: fiction, horror
exec BOOKCATEGORY_INSERT(2, 3, 1, 1, SYSDATE, SYSDATE);

exec BOOKCATEGORY_INSERT(2, 6, 1, 1, SYSDATE, SYSDATE);

--1984: science-fiction
exec BOOKCATEGORY_INSERT(3, 8, 1, 1, SYSDATE, SYSDATE);

--animal farm: fantasy
exec BOOKCATEGORY_INSERT(4, 9, 1, 1, SYSDATE, SYSDATE);

--cosmos: science, non-fantastic
exec BOOKCATEGORY_INSERT(5, 2, 1, 1, SYSDATE, SYSDATE);

exec BOOKCATEGORY_INSERT(5, 5, 1, 1, SYSDATE, SYSDATE);

--the metamorphosis: fiction, classic
exec BOOKCATEGORY_INSERT(6, 3, 1, 1, SYSDATE, SYSDATE);

exec BOOKCATEGORY_INSERT(6, 7, 1, 1, SYSDATE, SYSDATE);

--a game of thrones: fantastic, fiction
exec BOOKCATEGORY_INSERT(7, 1, 1, 1, SYSDATE, SYSDATE);

exec BOOKCATEGORY_INSERT(7, 3, 1, 1, SYSDATE, SYSDATE);

--one hundred years of solitude: fiction, classic
exec BOOKCATEGORY_INSERT(8, 3, 1, 1, SYSDATE, SYSDATE);

exec BOOKCATEGORY_INSERT(8, 7, 1, 1, SYSDATE, SYSDATE);

--a briefer history of time: science, non-fiction
exec BOOKCATEGORY_INSERT(9, 2, 1, 1, SYSDATE, SYSDATE);

exec BOOKCATEGORY_INSERT(9, 4, 1, 1, SYSDATE, SYSDATE);

--the brothers karamazov: fiction, classic
exec BOOKCATEGORY_INSERT(10, 3, 1, 1, SYSDATE, SYSDATE);

exec BOOKCATEGORY_INSERT(10, 7, 2, 2, SYSDATE, SYSDATE);






exec PUBLISHER_INSERT('Mariner Books', 'Mariner Books, a division of Houghton Mifflin Harcourt, was established in 1997 as a publisher of fiction, non-fiction, and poetry in paperback. Mariner is also the publisher of the Harvest imprint backlist, formerly published by Harcourt Brace/Harcourt Brace Jovanovich.', 1, 1, SYSDATE, SYSDATE);

exec PUBLISHER_INSERT('Houghton Mifflin Harcourt', 'Houghton Mifflin Harcourt is an educational and trade publisher in the United States. Headquartered in Boston''s Back Bay, it publishes textbooks, instructional technology materials, assessments, reference works, and fiction and non-fiction for both young readers and adults.', 1, 1, SYSDATE, SYSDATE);

exec PUBLISHER_INSERT('HarperCollins Publishers', 'HarperCollins Publishers LLC is one of the world''s largest publishing companies and is part of the "Big Five" English-language publishing companies, alongside Hachette, Holtzbrinck/Macmillan, Penguin Random House, and Simon &' || 'Schuster. The company is headquartered in New York City and is a subsidiary of News Corp.', 1, 1, SYSDATE, SYSDATE);

exec PUBLISHER_INSERT('New English Library', 'The New English Library was a United Kingdom book publishing company, which became an imprint of Hodder Headline.', 1, 1, SYSDATE, SYSDATE);

exec PUBLISHER_INSERT('New American Library', 'The New American Library (NAL) is an American publisher based in New York, founded in 1948. Its initial focus was affordable paperback reprints of classics and scholarly works, as well as popular and pulp fiction but now publishes trade and hardcover titles. It is currently an imprint of Penguin Random House; it was announced in 2015 that the imprint would publish only nonfiction titles.', 1, 1, SYSDATE, SYSDATE);

exec PUBLISHER_INSERT('Random House', 'Random House is the largest general-interest paperback publisher in the world.[1][2][3] As of 2013, it is part of Penguin Random House, which is jointly owned by German media conglomerate Bertelsmann and British global education and publishing company Pearson PLC.', 1, 1, SYSDATE, SYSDATE);

exec PUBLISHER_INSERT('Ballantine Books', 'Ballantine Books is a major book publisher located in the United States, founded in 1952 by Ian Ballantine with his wife, Betty Ballantine. It was acquired by Random House in 1973, which in turn was acquired by Bertelsmann in 1998 and remains part of that company today. Ballantine''s logo is a pair of mirrored letter Bs back to back. The firm''s early editors were Stanley Kauffman and Bernard Shir-Cliff.', 1, 1, SYSDATE, SYSDATE);

exec PUBLISHER_INSERT('Bantam Books', 'Bantam Books is an American publishing house owned entirely by parent company Random House, a subsidiary of Penguin Random House; it is an imprint of the Random House Publishing Group. It was formed in 1945 by Walter B. Pitkin, Jr., Sidney B. Kramer, and Ian and Betty Ballantine. It has since been purchased several times by companies including National General, Carl Lindner''s American Financial and, most recently, Bertelsmann.', 1, 1, SYSDATE, SYSDATE);

exec PUBLISHER_INSERT('Can Yayınları', 'Can Yayınları (English: Life Publications) is a publishing company based in Istanbul, Turkey. It has published authors including Orhan Pamuk, Metin Kaçan and Hikmet Temel Akarsu. It publishes both fiction and non-fiction books. It is a member of the Turkish Publishers Association. It was founded in 1981 by Erdal Öz and others.', 1, 1, SYSDATE, SYSDATE);

exec PUBLISHER_INSERT('Farrar, Straus and Giroux', 'Farrar, Straus and Giroux (FSG) is an American book publishing company, founded in 1946 by Roger W. Straus, Jr. and John C. Farrar. FSG is known for publishing literary books, and its authors have won numerous awards, including Pulitzer Prizes, National Book Awards, and Nobel Peace Prizes. The publisher is currently a division of MacMillan, whose parent company is the German publishing conglomerate Georg von Holtzbrinck Publishing Group.', 1, 1, SYSDATE, SYSDATE);

exec PUBLISHER_INSERT('Penguin Books', 'Penguin Books is a British publishing house. It was founded in 1935 by Sir Allen Lane as a line of the publishers The Bodley Head, only becoming a separate company the following year. Penguin revolutionised publishing in the 1930s through its inexpensive paperbacks, sold through Woolworths and other high street stores for sixpence, bringing high-quality paperback fiction and non-fiction to the mass market. Penguin''s success demonstrated that large audiences existed for serious books.', 1, 1, SYSDATE, SYSDATE);

exec PUBLISHER_INSERT('Blackstone Audio', 'Blackstone Audio is one of the largest independent audiobook publishers in the United States, offering over 10,000 audiobooks. The company is based in Ashland, Oregon with five in-house recording studios.', 1, 1, sysdate, sysdate);

exec PUBLISHER_INSERT('Phoenix Books', 'Phoenix is a paperback imprint of the Orion Publishing Group. It was established as the paperback imprint of Weidenfeld &' || 'Nicolson, which Orion negotiated to acquire soon after it was established in 1991', 1, 1, sysdate, sysdate);

exec PUBLISHER_INSERT('Recorded Books', 'Recorded Books is an audiobook publishing company with operations in the United States, United Kingdom and Australia. It provides products and services to retail customers and libraries.', 1, 1, sysdate, sysdate);

exec PUBLISHER_INSERT('Audible Studios', 'Audible Inc. is a seller and producer of spoken audio entertainment, information, and educational programming on the Internet. Audible sells digital audiobooks, radio and TV programs, and audio versions of magazines and newspapers.', 1, 1, sysdate, sysdate);

exec PUBLISHER_INSERT('Naxos AudioBooks', 'Naxos AudioBooks was founded in 1994 by Klaus Heymann and Nicolas Soames with the purpose of providing classic literature with classical music on CD and cassette.', 1, 1, sysdate, sysdate);

exec PUBLISHER_INSERT('Brilliance Audio', 'Brilliance Audio is an audiobook publisher founded in 1984 by Michael Snodgrass in Grand Haven, Michigan.', 2, 2, sysdate, sysdate);






exec EBOOK_INSERT(2.3, 'english', 322, 1, 1, 1, 1, SYSDATE, SYSDATE, TO_DATE('09/05/2003', 'mm/dd/yyyy'), 'twotowers_mariner_2003.epub');

exec EBOOK_INSERT(2.3, 'english', 328, 1, 2, 1, 1, SYSDATE, SYSDATE, TO_DATE('01/01/1982', 'mm/dd/yyyy'), 'twotowers_houghton_1982.epub');

exec EBOOK_INSERT(2.3, 'english', 439, 1, 3, 1, 1, SYSDATE, SYSDATE, TO_DATE('03/19/1999', 'mm/dd/yyyy'), 'twotowers_harper_1999.epub');

exec EBOOK_INSERT(2.3, 'english', 447, 2, 4, 1, 1, SYSDATE, SYSDATE, TO_DATE('07/01/1980', 'mm/dd/yyyy'), 'shining_newenglish_1980.epub');

exec EBOOK_INSERT(2.3, 'english', 328, 3, 5, 1, 1, SYSDATE, SYSDATE, TO_DATE('07/01/1950', 'mm/dd/yyyy'), '1984_newamerican_1950.epub');

exec EBOOK_INSERT(2.3, 'english', 311, 3, 2, 1, 1, SYSDATE, SYSDATE, TO_DATE('09/03/2013', 'mm/dd/yyyy'), '1984_houghton_2013.epub');

exec EBOOK_INSERT(2.3, 'english', 326, 3, 11, 1, 1, SYSDATE, SYSDATE, TO_DATE('07/03/2008', 'mm/dd/yyyy'), '1984_penguin_2008.epub');

exec EBOOK_INSERT(2.3, 'english', 95, 4, 11, 1, 1, SYSDATE, SYSDATE, TO_DATE('07/03/2008', 'mm/dd/yyyy'), 'animalfarm_penguin_2008.epub');

exec EBOOK_INSERT(2.3, 'turkish', 152, 4, 9, 1, 1, SYSDATE, SYSDATE, TO_DATE('2013', 'yyyy'), 'animalfarm_can_2013.epub');

exec EBOOK_INSERT(2.3, 'english', 384, 5, 6, 1, 1, SYSDATE, SYSDATE, TO_DATE('05/07/2002', 'mm/dd/yyyy'), 'cosmos_randomhouse_2002.epub');

exec EBOOK_INSERT(2.3, 'english', 324, 5, 7, 1, 1, SYSDATE, SYSDATE, TO_DATE('10/12/1985', 'mm/dd/yyyy'), 'cosmos_ballantine_1985.epub');

exec EBOOK_INSERT(2.3, 'english', 396, 5, 7, 1, 1, SYSDATE, SYSDATE, TO_DATE('12/10/2013', 'mm/dd/yyyy'), 'cosmos_ballantine_2013.epub');

exec EBOOK_INSERT(2.3, 'english', 98, 6, 11, 1, 1, SYSDATE, SYSDATE, TO_DATE('2006', 'yyyy'), 'metamorphos_penguin_2006.epub');

exec EBOOK_INSERT(2.3, 'turkish', 102, 6, 9, 1, 1, SYSDATE, SYSDATE, TO_DATE('03/2012', 'mm/yyyy'), 'metamorphosis_can_2012.epub');

exec EBOOK_INSERT(2.3, 'english', 835, 7, 8, 1, 1, SYSDATE, SYSDATE, TO_DATE('08/2005', 'mm/yyyy'), 'got_bantam_2005.epub');

exec EBOOK_INSERT(2.3, 'english', 457, 8, 3, 1, 1, SYSDATE, SYSDATE, TO_DATE('06/24/2003', 'mm/dd/yyyy'), '100ysolitude_harper_2003.epub');

exec EBOOK_INSERT(2.3, 'english', 458, 8, 3, 1, 1, SYSDATE, SYSDATE, TO_DATE('11/01/1998', 'mm/dd/yyyy'), '100ysolitude_harper_1998.epub');

exec EBOOK_INSERT(2.3, 'english', 176, 9, 8, 1, 1, SYSDATE, SYSDATE, TO_DATE('09/27/2005', 'mm/dd/yyyy'), 'brieferhot_bantam_2005.epub');

exec EBOOK_INSERT(2.3, 'english', 176, 9, 8, 1, 1, SYSDATE, SYSDATE, TO_DATE('05/13/2008', 'mm/dd/yyyy'), 'brieferhot_bantam_2008.epub');

exec EBOOK_INSERT(2.3, 'english', 795, 10, 10, 2, 2, SYSDATE, SYSDATE, TO_DATE('06/14/2002', 'mm/dd/yyyy'), 'karamazov_fsg_2002.epub');

exec EBOOK_INSERT(2.3, 'english', 1013, 10, 11, 2, 2, SYSDATE, SYSDATE, TO_DATE('02/2003', 'mm/yyyy'), 'karamazov_penguin_2003.epub');

exec EBOOK_INSERT(2.3, 'english', 1045, 10, 8, 2, 2, SYSDATE, SYSDATE, TO_DATE('04/01/1984', 'mm/dd/yyyy'), 'karamazov_bantam_1984.epub');





exec AUDIOBOOK_INSERT(2.3, 'english', 322, 1, 14, 2, 2, SYSDATE, SYSDATE, TO_DATE('09/05/2003', 'mm/dd/yyyy'), 16.40, 'twotowers_recorded_2003.mp3');

exec AUDIOBOOK_INSERT(2.3, 'english', 447, 2, 6, 1, 1, SYSDATE, SYSDATE, TO_DATE('07/01/1980', 'mm/dd/yyyy'), 15.56, 'shining_randomhouse_1980.mp3');

exec AUDIOBOOK_INSERT(2.3, 'english', 328, 3, 12, 1, 1, SYSDATE, SYSDATE, TO_DATE('07/01/1950', 'mm/dd/yyyy'), 11.26, '1984_blackstone_1950.mp3');

exec AUDIOBOOK_INSERT(2.3, 'english', 95, 4, 12, 1, 1, SYSDATE, SYSDATE, TO_DATE('07/03/2008', 'mm/dd/yyyy'), 3.13, 'animalfarm_blackstone_2008.mp3');

exec AUDIOBOOK_INSERT(2.3, 'english', 384, 5, 17, 1, 1, SYSDATE, SYSDATE, TO_DATE('05/07/2002', 'mm/dd/yyyy'), 14, 'cosmos_brilliance_2002.mp3');

exec AUDIOBOOK_INSERT(2.3, 'english', 201, 6, 15, 1, 1, SYSDATE, SYSDATE, TO_DATE('03/01/1972', 'mm/dd/yyyy'), 2.8, 'metamorphosis_audible_1972.mp3');

exec AUDIOBOOK_INSERT(2.3, 'english', 835, 7, 6, 1, 1, SYSDATE, SYSDATE, TO_DATE('08/01/2005', 'mm/dd/yyyy'), 33.50, 'gameofthrones_random_2005.mp3');

exec AUDIOBOOK_INSERT(2.3, 'english', 457, 8, 12, 1, 1, SYSDATE, SYSDATE, TO_DATE('06/24/2003', 'mm/dd/yyyy'), 14.4, 'solitude_blackstone_2003.mp3');

exec AUDIOBOOK_INSERT(2.3, 'english', 212, 9, 13, 1, 1, SYSDATE, SYSDATE, TO_DATE('09/01/1998', 'mm/dd/yyyy'), 5.50, 'briefhistory_phoenix_1998.mp3');

exec AUDIOBOOK_INSERT(2.3, 'english', 795, 10, 16, 1, 1, SYSDATE, SYSDATE, TO_DATE('06/14/2002', 'mm/dd/yyyy'), 37.8, 'karamazov_naxos_2002.mp3');


--- USERNAME: LSILK BOOKNAME: TWO TOWERS
exec LIBRARY_INSERT(3, 1);

--- USERNAME:ABERA BOOKNAME: ANIMAL FARM
exec LIBRARY_INSERT(4, 8);

--- USERNAME:WVEIT BOOKNAME: A BRIEFER HISTORY OF TIME
exec LIBRARY_INSERT(5, 18);

--- USERNAME:SJOHN BOOKNAME: THE METAMORPHOSIS
exec LIBRARY_INSERT(6, 13);

--- USERNAME:AROTTER BOOKNAME: THE COSMOS
exec LIBRARY_INSERT(7, 11);

--efrink: the two towers
exec LIBRARY_INSERT(8, 1);
--mbeachy: cosmos
exec LIBRARY_INSERT(9, 5);
--tcurtiss: a game of thrones
exec LIBRARY_INSERT(10, 7);
--ecoursey: 1984
exec LIBRARY_INSERT(11, 3);
--ecoursey: a game of thrones
exec LIBRARY_INSERT(11, 7);
--mkreiger: the brothers karamazov
exec LIBRARY_INSERT(12, 10);



exec SHELF_INSERT('New Shelf', 3, 0);

exec SHELF_INSERT('Anderson''s Shelf', 4, 1);

exec SHELF_INSERT('Wonderful Books', 5, 1);

exec SHELF_INSERT('New Shelf', 6, 1);

exec SHELF_INSERT('My Lovely Books', 7, 1);

exec SHELF_INSERT('New Shelf', 7, 0);

exec SHELF_INSERT('New Shelf', 8, 0);

exec SHELF_INSERT('Favorites', 9, 1);

exec SHELF_INSERT('Fantastic', 10, 0);

exec SHELF_INSERT('New Shelf', 11, 1);

exec SHELF_INSERT('Relax', 12, 0);

exec SHELF_INSERT('Scientific', 12, 1);



exec SHELFFILE_INSERT(3, 1, 5);

exec SHELFFILE_INSERT(4, 2, 15);

exec SHELFFILE_INSERT(5, 3, 28);

exec SHELFFILE_INSERT(6, 4, 7);

exec SHELFFILE_INSERT(7, 5, 10);

exec SHELFFILE_INSERT(7, 6, 13);

exec SHELFFILE_INSERT(8, 7, 32);

exec SHELFFILE_INSERT(9, 8, 17);

exec SHELFFILE_INSERT(10, 9, 23);

exec SHELFFILE_INSERT(11, 10, 29);

exec SHELFFILE_INSERT(12, 11, 9);

exec SHELFFILE_INSERT(12, 12, 16);


-- UPDATE PROCEDURES : Updates last elements on the tables. --

-- username and region updated.
exec COMMERCIALUSER_UPDATE(12, 'NEWUSERNAMEOFM.KREIGER', '098safasn84', 'Maximina', 'Kreiger', 'EUROPE', 0);

-- phone number updated.
exec CONTACT_UPDATE(2, 'Turkey', 'Ankara', '5559998877');

-- password and city updated.
exec SYSTEMUSER_UPDATE(2, 'Luo', 'abc123', 'Berk', 'Özata', 'middle-east', 1, 1, 'Turkey', 'Istanbul', '5559998877');

-- author's image updated.
exec AUTHOR_UPDATE(10, 'Fyodor M. Dostoyevsky', 'Dostoevsky, was a Russian novelist, journalist, and short-story writer whose psychological penetration into the human soul had a profound influence on the 20th century novel.', 'dostoyevskiNewImage.jpg', 1, 1, TO_DATE('04/08/2017', 'mm/dd/yyyy'),TO_DATE('04/08/2017', 'mm/dd/yyyy'));

-- book's summary updated.
exec BOOK_UPDATE(10, 'The Brothers Karamazov', 'The award-winning translation of Dostoevsky''s last and greatest novel. The Brothers Karamazov is a passionate philosophical novel set in 19th century Russia, that enters deeply into the ethical debates of God, free will, and morality. It is a spiritual drama of moral struggles concerning faith, doubt, and reason, set against a modernizing Russia.', 'karamazov.jpg', 1, 1, TO_DATE('04/08/2017', 'mm/dd/yyyy'),TO_DATE('04/08/2017', 'mm/dd/yyyy'));

-- file's page number updated.
exec FILE_UPDATE(32, 2.3,	'english', 680,	10, 16, 1, 1, TO_DATE('04/08/2017', 'mm/dd/yyyy'),TO_DATE('04/08/2017', 'mm/dd/yyyy'), TO_DATE('06/14/2002', 'mm/dd/yyyy'));

-- shelf's name updated.
exec SHELF_UPDATE(12, 'My Scientific Books', 12, 1);

-- publisher's name updated.
exec PUBLISHER_UPDATE(17, 'Brialliance Audio Inc', 'Brilliance Audio is an audiobook publisher founded in 1984 by Michael Snodgrass in Grand Haven, Michigan.', 2, 2, TO_DATE('04/08/2017', 'mm/dd/yyyy'),TO_DATE('04/08/2017', 'mm/dd/yyyy'));



-- DELETE PROCEDURES:

-- it will be deletede from audiobook and file tables.
-- also the related rows will be deleted from library and shelves.
exec AUDIOBOOK_DELETE(29);

-- book and its published editions will be deleted from file table
-- also the related rows will be deleted from library and shelves.
exec BOOK_DELETE(1);

-- it will be deleted from commercial user and user tables.
-- user's payment details, library, shelf and books on his/her shelf will be deleted also.
exec COMMERCIALUSER_DELETE(12);

-- it will not be deleted, just will be inactive.
exec SYSTEMUSER_DELETE(1);
